<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cctv;

class CctvController extends Controller {
    public function stream($id) {
        $cctv = Cctv::findOrFail($id);
        
        // Assuming the stream URL is stored in the CCTV model
        return response()->json([
            'stream_url' => $cctv->stream_url // Adjust this based on your actual field
        ]);
    }
    public function index() {
        return Cctv::with('location')->get();
    }

    public function show($id) {
        return Cctv::with('location')->findOrFail($id);
    }
}