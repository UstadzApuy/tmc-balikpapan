<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $query = Location::query();
        
        // Filter by kecamatan if provided
        if ($request->has('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }
        
        $locations = $query->get()->map(function ($location) {
            return [
                'id' => $location->id,
                'name' => $location->name,
                'kecamatan' => $location->kecamatan,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
            ];
        });
        
        return response()->json([
            'locations' => $locations,
            'message' => 'Locations retrieved successfully'
        ]);
    }
    
    public function kecamatans()
    {
        $kecamatans = Location::select('kecamatan')
            ->distinct()
            ->orderBy('kecamatan')
            ->pluck('kecamatan');
            
        return response()->json([
            'kecamatans' => $kecamatans,
            'message' => 'Kecamatans retrieved successfully'
        ]);
    }

    public function cctvs($locationId)
    {
        $location = Location::findOrFail($locationId);
        
        $cctvs = $location->cctvs()
            ->select('id', 'name', 'description', 'hls_url', 'rtsp_url', 'status')
            ->where('status', 'active')
            ->get()
            ->map(function ($cctv) {
                return [
                    'id' => $cctv->id,
                    'name' => $cctv->name,
                    'description' => $cctv->description,
                    'has_stream' => !empty($cctv->hls_url) || !empty($cctv->rtsp_url),
                    'stream_url' => $cctv->hls_url ?? $cctv->rtsp_url
                ];
            });
            
        return response()->json([
            'cctvs' => $cctvs,
            'message' => 'CCTVs retrieved successfully'
        ]);
    }
}
