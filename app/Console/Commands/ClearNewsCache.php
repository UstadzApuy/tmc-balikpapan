<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearNewsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear news selection cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        cache()->forget('selected_news_global');
        cache()->forget('selected_scope');
        cache()->forget('selected_kecamatan');
        cache()->forget('selected_locations');
        
        $this->info('News cache cleared successfully!');
    }
}