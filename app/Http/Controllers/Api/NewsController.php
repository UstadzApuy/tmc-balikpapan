<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('locations')
            ->where('is_active', true)
            ->latest();
    
        // Filter berdasarkan location_id
        if ($request->has('location_id')) {
            $query->whereHas('locations', function($q) use ($request) {
                $q->where('locations.id', $request->location_id);
            });
        }
        
        // Filter berdasarkan kecamatan
        if ($request->has('kecamatan')) {
            $query->whereHas('locations', function($q) use ($request) {
                $q->where('kecamatan', $request->kecamatan);
            });
        }
    
        $news = $query->get()->map(function ($news) {
            return [
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'weather_condition' => $news->weather_condition,
                'locations' => $news->locations->map(function ($location) {
                    return [
                        'id' => $location->id,
                        'name' => $location->name,
                        'kecamatan' => $location->kecamatan,
                        'latitude' => $location->latitude,
                        'longitude' => $location->longitude,
                    ];
                }),
                'created_at' => $news->created_at->toDateTimeString(),
            ];
        });
    
        return response()->json([
            'news' => $news,
            'message' => 'News retrieved successfully'
        ]);
    }

    public function show($id)
    {
        $news = News::with('locations')->findOrFail($id);
        
        return response()->json([
            'news' => [
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'weather_condition' => $news->weather_condition,
                'locations' => $news->locations->map(function ($location) {
                    return [
                        'id' => $location->id,
                        'name' => $location->name,
                        'kecamatan' => $location->kecamatan,
                        'latitude' => $location->latitude,
                        'longitude' => $location->longitude,
                    ];
                }),
                'created_at' => $news->created_at->toDateTimeString(),
            ]
        ]);
    }
}
