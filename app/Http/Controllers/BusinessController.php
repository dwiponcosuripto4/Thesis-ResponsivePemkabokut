<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Services\GoogleMapsParser;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBusinessRequest;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $businesses = Business::where('status', 1)->latest()->get();
        return view('umkm.data', compact('businesses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('umkm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(StoreBusinessRequest $request)
    {
        $data = $request->validated();
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $originalName = $foto->getClientOriginalName();
            $safeName = uniqid().'-'.$originalName;
            $path = $foto->storeAs('umkm', $safeName, 'public');
            $fotoPath = $path;
        }
        $data['foto'] = $fotoPath;

        $lat = $data['latitude']  ?? null;
        $lng = $data['longitude'] ?? null;

        $url = $data['input_url'] ?? null;
        if ((is_null($lat) || is_null($lng)) && $url) {
            if (class_exists(GoogleMapsParser::class)) {
                if ($coords = GoogleMapsParser::extractLatLng($url)) {
                    $lat = $coords['lat'];
                    $lng = $coords['lng'];
                }
            }
        }

        $data['latitude']  = $lat;
        $data['longitude'] = $lng;

        $data['status']  = 0;          
        $data['user_id'] = auth()->id();   

        // Simpan
        $business = Business::create($data);

        return redirect()
            ->route('umkm.show', $business->id) 
            ->with('success', 'UMKM berhasil didaftarkan dan menunggu persetujuan.');
    }


    /**
     * Display the specified resource.
     */
     public function show(string $id)
    {
        $business = Business::findOrFail($id);
        $embed = null;

        if (!is_null($business->latitude) && !is_null($business->longitude)) {
            if (class_exists(GoogleMapsParser::class)) {
                $embed = GoogleMapsParser::embedUrlFromLatLng($business->latitude, $business->longitude);
            } else {
                $lat = $business->latitude;
                $lng = $business->longitude;
                $embed = "https://www.google.com/maps?q={$lat},{$lng}&z=16&hl=id&output=embed";
            }
        } else {
            $query = $business->alamat ?: $business->input_url ?: $business->nama;
            if (class_exists(GoogleMapsParser::class)) {
                $embed = GoogleMapsParser::embedUrlFromQuery($query);
            } else {
                $embed = "https://www.google.com/maps?q=" . urlencode($query) . "&z=16&hl=id&output=embed";
            }
        }

        return view('umkm.show', compact('business', 'embed'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $business = Business::findOrFail($id);
        if ($business->foto) {
            Storage::disk('public')->delete($business->foto);
        }
        
        $business->delete();
        
        return redirect()->route('umkm.index')->with('success', 'UMKM berhasil dihapus.');
    }

    /**
     * Approve business
     */
    public function approve(string $id)
    {
        $business = Business::findOrFail($id);
        $business->update(['status' => 1]);
        
        return redirect()->back()->with('success', 'UMKM berhasil disetujui.');
    }

    /**
     * Reject business
     */
    public function reject(string $id)
    {
        $business = Business::findOrFail($id);
        $business->update(['status' => 0]);
        
        return redirect()->back()->with('success', 'UMKM ditolak.');
    }

    /**
     * Expand short Google Maps URL for AJAX preview
     */
    public function expandUrl(Request $request)
    {
        $url = $request->input('url');
        
        if (!$url) {
            return response()->json(['success' => false, 'message' => 'URL tidak ditemukan']);
        }

        try {
            if (GoogleMapsParser::isShortUrl($url)) {
                $expandedUrl = GoogleMapsParser::expandShortUrl($url);
                
                if ($expandedUrl) {
                    return response()->json([
                        'success' => true,
                        'expandedUrl' => $expandedUrl,
                        'originalUrl' => $url
                    ]);
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Bukan link pendek atau gagal expand',
                'originalUrl' => $url
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'originalUrl' => $url
            ]);
        }
    }

}
