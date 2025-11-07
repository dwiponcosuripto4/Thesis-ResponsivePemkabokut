<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Category;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index()
    {
        $data = Data::all();
        return view('admin.data.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.data.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Data::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('data.index')->with('success', 'Data created successfully.');
    }

    public function destroy($id)
    {
        $data = Data::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        $data->delete();

        return redirect()->route('data.index')->with('success', 'Data deleted successfully.');
    }
    public function show($id)
    {
        $data = Data::with(['category', 'documents.file'])->findOrFail($id);
        return view('data.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Data::findOrFail($id);
        $categories = Category::all();
        return view('admin.data.edit', compact('data', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = Data::findOrFail($id);
        $data->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('data.index')->with('success', 'Data updated successfully.');
    }
}
