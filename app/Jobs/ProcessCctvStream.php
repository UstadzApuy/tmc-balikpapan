<?php

namespace App\Jobs;

use App\Models\Cctv;
use App\Services\StreamingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCctvStream implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cctv;
    public $action;

    /**
     * Create a new job instance.
     */
    public function __construct(Cctv $cctv, string $action = 'start')
    {
        $this->cctv = $cctv;
        $this->action = $action;
    }

    /**
     * Execute the job.
     */
    public function handle(StreamingService $streamingService): void
    {
        Log::info("Processing CCTV stream job", [
            'cctv_id' => $this->cctv->id,
            'action' => $this->action
        ]);

        try {
            if ($this->action === 'start') {
                $streamingService->startStream($this->cctv);
            } elseif ($this->action === 'stop') {
                $streamingService->stopStream($this->cctv);
            } elseif ($this->action === 'restart') {
                $streamingService->stopStream($this->cctv);
                sleep(2); // Brief pause before restart
                $streamingService->startStream($this->cctv);
            }
        } catch (\Exception $e) {
            Log::error("Error processing CCTV stream job", [
                'cctv_id' => $this->cctv->id,
                'action' => $this->action,
                'error' => $e->getMessage()
            ]);
            
            // Retry logic
            if ($this->attempts() < 3) {
                $this->release(60); // Retry after 1 minute
            } else {
                $this->fail($e);
            }
        }
    }

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("CCTV stream job failed permanently", [
            'cctv_id' => $this->cctv->id,
            'action' => $this->action,
            'error' => $exception->getMessage()
        ]);
    }
}
