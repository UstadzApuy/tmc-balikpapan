<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupStreaming extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'streaming:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup streaming directories and permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up streaming infrastructure...');

        // Create HLS output directory
        $hlsPath = public_path('streams/hls');
        
        if (!File::exists($hlsPath)) {
            File::makeDirectory($hlsPath, 0755, true);
            $this->info("Created directory: {$hlsPath}");
        } else {
            $this->info("Directory already exists: {$hlsPath}");
        }

        // Create .htaccess for HLS streaming
        $htaccessContent = <<<EOT
# Enable CORS for HLS streaming
Header set Access-Control-Allow-Origin "*"
Header set Access-Control-Allow-Methods "GET, OPTIONS"
Header set Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept, Authorization"

# Handle preflight requests
RewriteEngine On
RewriteCond %{REQUEST_METHOD} OPTIONS
RewriteRule ^(.*)$ $1 [R=200,L]

# Cache settings for HLS segments
<FilesMatch "\.(m3u8|ts)$">
    ExpiresActive On
    ExpiresDefault "access plus 1 minute"
    Header set Cache-Control "public, max-age=60"
</FilesMatch>

# Prevent direct access to segment files
<FilesMatch "^segment_\d+\.ts$">
    Order allow,deny
    Allow from all
</FilesMatch>
EOT;

        $htaccessPath = $hlsPath . '/.htaccess';
        File::put($htaccessPath, $htaccessContent);
        $this->info("Created .htaccess for HLS streaming");

        // Create index.html for testing
        $indexContent = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <title>CCTV Streaming Test</title>
    <link href="https://vjs.zencdn.net/8.0.4/video-js.css" rel="stylesheet">
</head>
<body>
    <h1>CCTV Streaming Test</h1>
    <p>This is a test page for HLS streaming. Check the streams/hls directory for available streams.</p>
    
    <script src="https://vjs.zencdn.net/8.0.4/video.min.js"></script>
</body>
</html>
EOT;

        File::put($hlsPath . '/index.html', $indexContent);
        $this->info("Created test index.html");

        $this->info('Streaming setup complete!');
        $this->info('Next steps:');
        $this->info('1. Install FFmpeg: php artisan ffmpeg:install');
        $this->info('2. Run migrations: php artisan migrate');
        $this->info('3. Start streaming: php artisan cctv:streams:start --all');
        
        return 0;
    }
}
