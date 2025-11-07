<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::all();
        return view('index', compact('files'));
    }
    public function data(Request $request)
    {
        // Get sort direction (default: desc = terbaru)
        $sort = $request->get('sort', 'desc');
        
        $query = File::query();
        $documents = Document::all();

        // Apply document filter
        if ($request->filled('document_id')) {
            $query->where('document_id', $request->document_id);
        }

        // Apply search filter
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Apply sorting by file_date
        $query->orderBy('file_date', $sort);

        $files = $query->get();
        return view('admin.file.data', compact('files', 'documents'));
    }

    public function download($id)
    {
        $file = File::findOrFail($id);
        $filePath = $file->file_path;

        if (is_string($filePath)) {
            $filePath = trim($filePath, '"');
            $filePath = str_replace('\/', '/', $filePath);
        }

        if (is_array($filePath)) {
            $filePath = $filePath[0] ?? null;
            if ($filePath) {
                $filePath = str_replace('\/', '/', $filePath);
            }
        }

        if (is_string($filePath) && (str_starts_with($filePath, 'http://') || str_starts_with($filePath, 'https://'))) {
            return redirect($filePath);
        }

        if (!$filePath) {
            abort(404, 'File path not found');
        }

        $pathToFile = storage_path('app/' . $filePath);

        if (!file_exists($pathToFile)) {
            abort(404, 'File not found in storage');
        }

        return response()->download($pathToFile);
    }

    public function edit($id)
    {
        $file = File::findOrFail($id);
        $documents = Document::all();
        return view('admin.file.edit', compact('file', 'documents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip,rar,xls,xlsx|max:20000',
            'file_date' => 'required|date',
            'document_id' => 'nullable|exists:documents,id',
        ]);

        $file = File::findOrFail($id);
        if ($request->hasFile('file_path')) {
            if (Storage::exists($file->file_path)) {
                Storage::delete($file->file_path);
            }

            $newFile = $request->file('file_path');
            $originalName = $newFile->getClientOriginalName();
            $path = $newFile->storeAs('files', $originalName);
            $file->file_path = $path;
        }

        $file->title = $request->title;
        $file->file_date = $request->file_date;
        $file->document_id = $request->document_id;
        $file->save();

        return redirect()->route('file.data')->with('success', 'File updated successfully.');
    }

    public function destroy($id)
    {
        $file = File::findOrFail($id);
        if (Storage::exists($file->file_path)) {
            Storage::delete($file->file_path);
        }
        $file->delete();

        return redirect()->route('file.data')->with('success', 'File deleted successfully.');
    }

    public function destroyAjax($id)
    {
        try {
            $file = File::findOrFail($id);
            if (Storage::exists($file->file_path)) {
                Storage::delete($file->file_path);
            }
            $file->delete();

            return response()->json(['success' => true, 'message' => 'File deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting file']);
        }
    }

    public function show($id)
    {
        $file = File::find($id);
        return view('admin.file.show', compact('file'));
    }

    public function serve($id)
    {
        $file = File::findOrFail($id);
        $filePath = $file->file_path;
        if (is_string($filePath)) {
            $filePath = trim($filePath, '"');
            $filePath = str_replace('\/', '/', $filePath);
        }
        if (is_array($filePath)) {
            $filePath = $filePath[0] ?? null;
            if ($filePath) {
                $filePath = str_replace('\/', '/', $filePath);
            }
        }
        if (is_string($filePath) && (str_starts_with($filePath, 'http://') || str_starts_with($filePath, 'https://'))) {
            return redirect($filePath);
        }
        if (!$filePath) {
            abort(404, 'File path not found');
        }
        $pathToFile = storage_path('app/' . $filePath);

        if (!file_exists($pathToFile)) {
            abort(404, 'File not found in storage');
        }
        $extension = strtolower(pathinfo($pathToFile, PATHINFO_EXTENSION));
        $headers = [];
        switch ($extension) {
            case 'pdf':
                $headers['Content-Type'] = 'application/pdf';
                break;
            case 'jpg':
            case 'jpeg':
                $headers['Content-Type'] = 'image/jpeg';
                break;
            case 'png':
                $headers['Content-Type'] = 'image/png';
                break;
            case 'gif':
                $headers['Content-Type'] = 'image/gif';
                break;
            case 'webp':
                $headers['Content-Type'] = 'image/webp';
                break;
            case 'xls':
                $headers['Content-Type'] = 'application/vnd.ms-excel';
                break;
            case 'xlsx':
                $headers['Content-Type'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                break;
            default:
                $headers['Content-Type'] = 'application/octet-stream';
        }

        return response()->file($pathToFile, $headers);
    }
}
