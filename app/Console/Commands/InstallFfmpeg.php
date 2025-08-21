<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class InstallFfmpeg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ffmpeg:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install FFmpeg on the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking FFmpeg installation...');

        // Check if FFmpeg is already installed
        $result = Process::run('ffmpeg -version');
        
        if ($result->successful()) {
            $this->info('FFmpeg is already installed');
            $this->line($result->output());
            return 0;
        }

        $this->warn('FFmpeg not found. Please install FFmpeg manually.');
        
        // Provide installation instructions based on OS
        if (PHP_OS_FAMILY === 'Windows') {
            $this->info('Windows installation:');
            $this->line('1. Download FFmpeg from https://ffmpeg.org/download.html#build-windows');
            $this->line('2. Extract to C:\\ffmpeg');
            $this->line('3. Add C:\\ffmpeg\\bin to your PATH environment variable');
            $this->line('4. Restart your terminal/IDE');
        } elseif (PHP_OS_FAMILY === 'Linux') {
            $this->info('Linux installation:');
            $this->line('Ubuntu/Debian: sudo apt update && sudo apt install ffmpeg');
            $this->line('CentOS/RHEL: sudo yum install ffmpeg');
            $this->line('Arch: sudo pacman -S ffmpeg');
        } elseif (PHP_OS_FAMILY === 'Darwin') {
            $this->info('macOS installation:');
            $this->line('1. Install Homebrew if not already installed: /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"');
            $this->line('2. Install FFmpeg: brew install ffmpeg');
        }

        return 1;
    }
}
