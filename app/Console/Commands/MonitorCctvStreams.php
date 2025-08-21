<?php

namespace App\Console\Commands;

use App\Models\Cctv;
use App\Services\StreamingService;
use Illuminate\Console\Command;

class MonitorCctvStreams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cctv:streams:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor CCTV streams and restart failed ones';

    /**
     * Execute the console command.
     */
    public function handle(StreamingService $streamingService)
    {
        $this->info('Monitoring CCTV streams...');

        $activeStreams = $streamingService->getActiveStreams();
        $this->info("Found " . count($activeStreams) . " active streams");

        $cctvs = Cctv::where('status', 'Active')
                    ->whereNotNull('rtsp_url')
                    ->get();

        $restarted = 0;
        $failed = 0;

        foreach ($cctvs as $cctv) {
            $isActive = $streamingService->isStreamActive($cctv);
            
            if (!$isActive && $cctv->hls_url) {
                $this->warn("Stream inactive for CCTV: {$cctv->name} (ID: {$cctv->id})");
                
                // Restart the stream
                \App\Jobs\ProcessCctvStream::dispatch($cctv, 'restart');
                $restarted++;
            } elseif (!$isActive && !$cctv->hls_url) {
                $this->warn("Stream not started for CCTV: {$cctv->name} (ID: {$cctv->id})");
                $failed++;
            }
        }

        $this->info("Monitor complete:");
        $this->info("- Restarted: {$restarted}");
        $this->info("- Failed: {$failed}");

        return 0;
    }
}
