<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cctv;
use App\Services\StreamingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StreamingController extends Controller
{
    protected $streamingService;

    public function __construct(StreamingService $streamingService)
    {
        $this->streamingService = $streamingService;
    }

    /**
     * Start streaming for a specific CCTV
     */
    public function start(Request $request, $id)
    {
        $cctv = Cctv::findOrFail($id);
        
        try {
            $success = $this->streamingService->startStream($cctv);
            
            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Stream started successfully',
                    'hls_url' => $cctv->hls_url
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to start stream'
            ], 500);
            
        } catch (\Exception $e) {
            Log::error("Error starting stream for CCTV {$id}", [
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error starting stream: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Stop streaming for a specific CCTV
     */
    public function stop(Request $request, $id)
    {
        $cctv = Cctv::findOrFail($id);
        
        try {
            $success = $this->streamingService->stopStream($cctv);
            
            return response()->json([
                'success' => $success,
                'message' => $success ? 'Stream stopped successfully' : 'Failed to stop stream'
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error stopping stream for CCTV {$id}", [
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error stopping stream: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get streaming status for a CCTV
     */
    public function status($id)
    {
        $cctv = Cctv::findOrFail($id);
        
        $isActive = $this->streamingService->isStreamActive($cctv);
        
        return response()->json([
            'cctv_id' => $cctv->id,
            'name' => $cctv->name,
            'status' => $cctv->status,
            'is_streaming' => $isActive,
            'hls_url' => $cctv->hls_url,
            'rtsp_url' => $cctv->rtsp_url
        ]);
    }

    /**
     * Get all streaming statuses
     */
    public function allStatus()
    {
        $cctvs = Cctv::where('status', 'Active')
                    ->whereNotNull('rtsp_url')
                    ->get();

        $statuses = [];
        foreach ($cctvs as $cctv) {
            $isActive = $this->streamingService->isStreamActive($cctv);
            $statuses[] = [
                'cctv_id' => $cctv->id,
                'name' => $cctv->name,
                'status' => $cctv->status,
                'is_streaming' => $isActive,
                'hls_url' => $cctv->hls_url,
                'rtsp_url' => $cctv->rtsp_url
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $statuses
        ]);
    }
}
