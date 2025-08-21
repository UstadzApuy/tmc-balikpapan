<?php

namespace App\Services;

use App\Models\Cctv;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class StreamingService
{
    protected $ffmpegPath;
    protected $hlsOutputPath;
    protected $segmentDuration = 4;
    protected $maxSegments = 50;

    public function __construct()
    {
        $this->ffmpegPath = config('streaming.ffmpeg_path', 'ffmpeg');
        $this->hlsOutputPath = public_path('streams/hls');
    }

    /**
     * Start HLS streaming for a CCTV
     */
    public function startStream(Cctv $cctv): bool
    {
        if (!$cctv->rtsp_url) {
            Log::warning("No RTSP URL for CCTV ID: {$cctv->id}");
            return false;
        }

        $outputDir = $this->getOutputDirectory($cctv->id);
        $playlistPath = $this->getPlaylistPath($cctv->id);

        // Ensure directory exists
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        // Build FFmpeg command
        $command = $this->buildFfmpegCommand($cctv->rtsp_url, $playlistPath);

        Log::info("Starting FFmpeg stream for CCTV ID: {$cctv->id}", [
            'command' => $command,
            'output_dir' => $outputDir
        ]);

        try {
            // Run FFmpeg in background
            $process = Process::timeout(0)->start($command);
            
            // Update CCTV with HLS URL
            $hlsUrl = url("streams/hls/cctv_{$cctv->id}/playlist.m3u8");
            $cctv->update(['hls_url' => $hlsUrl]);

            Log::info("HLS streaming started for CCTV ID: {$cctv->id}", [
                'hls_url' => $hlsUrl
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to start FFmpeg stream for CCTV ID: {$cctv->id}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Stop HLS streaming for a CCTV
     */
    public function stopStream(Cctv $cctv): bool
    {
        $outputDir = $this->getOutputDirectory($cctv->id);
        
        // Kill FFmpeg processes for this CCTV
        $this->killFfmpegProcesses($cctv->id);
        
        // Clean up files
        if (is_dir($outputDir)) {
            $this->removeDirectory($outputDir);
        }

        // Clear HLS URL
        $cctv->update(['hls_url' => null]);

        Log::info("HLS streaming stopped for CCTV ID: {$cctv->id}");
        return true;
    }

    /**
     * Check if stream is active
     */
    public function isStreamActive(Cctv $cctv): bool
    {
        $playlistPath = $this->getPlaylistPath($cctv->id);
        return file_exists($playlistPath) && (time() - filemtime($playlistPath)) < 30;
    }

    /**
     * Get output directory for CCTV
     */
    protected function getOutputDirectory(int $cctvId): string
    {
        return $this->hlsOutputPath . "/cctv_{$cctvId}";
    }

    /**
     * Get playlist path for CCTV
     */
    protected function getPlaylistPath(int $cctvId): string
    {
        return $this->getOutputDirectory($cctvId) . '/playlist.m3u8';
    }

    /**
     * Build FFmpeg command for RTSP to HLS conversion
     */
    protected function buildFfmpegCommand(string $rtspUrl, string $playlistPath): string
    {
        $outputDir = dirname($playlistPath);
        
        return implode(' ', [
            $this->ffmpegPath,
            '-i', escapeshellarg($rtspUrl),
            '-c:v', 'libx264',
            '-preset', 'veryfast',
            '-tune', 'zerolatency',
            '-c:a', 'aac',
            '-b:a', '128k',
            '-f', 'hls',
            '-hls_time', $this->segmentDuration,
            '-hls_list_size', $this->maxSegments,
            '-hls_flags', 'delete_segments',
            '-hls_allow_cache', '1',
            '-hls_segment_filename', escapeshellarg("{$outputDir}/segment_%03d.ts"),
            escapeshellarg($playlistPath),
            '> /dev/null 2>&1 &'
        ]);
    }

    /**
     * Kill FFmpeg processes for specific CCTV
     */
    protected function killFfmpegProcesses(int $cctvId): void
    {
        $playlistPath = $this->getPlaylistPath($cctvId);
        $escapedPath = str_replace('/', '\/', $playlistPath);
        
        // Find and kill FFmpeg processes
        $process = Process::run("ps aux | grep ffmpeg | grep {$escapedPath}");
        $output = $process->output();
        
        if ($output) {
            $lines = explode("\n", $output);
            foreach ($lines as $line) {
                if (preg_match('/^\s*(\d+)/', $line, $matches)) {
                    Process::run("kill -9 {$matches[1]}");
                }
            }
        }
    }

    /**
     * Remove directory and contents
     */
    protected function removeDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                $this->removeDirectory($path);
            } else {
                unlink($path);
            }
        }
        rmdir($dir);
    }

    /**
     * Get list of active streams
     */
    public function getActiveStreams(): array
    {
        $streams = [];
        $directories = glob($this->hlsOutputPath . '/cctv_*');
        
        foreach ($directories as $dir) {
            $playlistPath = $dir . '/playlist.m3u8';
            if (file_exists($playlistPath)) {
                $cctvId = (int) str_replace('cctv_', '', basename($dir));
                $streams[] = [
                    'cctv_id' => $cctvId,
                    'playlist_path' => $playlistPath,
                    'last_modified' => filemtime($playlistPath)
                ];
            }
        }
        
        return $streams;
    }
}
