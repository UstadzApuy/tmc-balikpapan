<?php

namespace App\Console\Commands;

use App\Models\Cctv;
use App\Jobs\ProcessCctvStream;
use Illuminate\Console\Command;

class StopCctvStreams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cctv:streams:stop
                            {--ids= : Comma-separated CCTV IDs to stop}
                            {--all : Stop all active streams}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stop HLS streaming for CCTV cameras';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Stopping CCTV streams...');

        $query = Cctv::where('status', 'Active')
                    ->whereNotNull('hls_url');

        if ($this->option('ids')) {
            $ids = explode(',', $this->option('ids'));
            $query->whereIn('id', $ids);
        } elseif (!$this->option('all')) {
            $this->error('Please specify --ids or --all option');
            return 1;
        }

        $cctvs = $query->get();

        if ($cctvs->isEmpty()) {
            $this->warn('No active CCTV streams found');
            return 0;
        }

        $this->info("Found {$cctvs->count()} active CCTV streams to stop");

        $bar = $this->output->createProgressBar($cctvs->count());
        $bar->start();

        foreach ($cctvs as $cctv) {
            $this->info("Stopping stream for CCTV: {$cctv->name} (ID: {$cctv->id})");
            
            // Dispatch job to stop streaming
            ProcessCctvStream::dispatch($cctv, 'stop');
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('All CCTV stream stop jobs have been dispatched');
        
        return 0;
    }
}
