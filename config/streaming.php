<?php

return [

    /*
    |--------------------------------------------------------------------------
    | FFmpeg Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for FFmpeg RTSP to HLS conversion
    |
    */

    'ffmpeg_path' => env('FFMPEG_PATH', 'ffmpeg'),
    
    'hls_output_path' => public_path('streams/hls'),
    
    'segment_duration' => env('HLS_SEGMENT_DURATION', 4),
    
    'max_segments' => env('HLS_MAX_SEGMENTS', 50),
    
    'stream_timeout' => env('STREAM_TIMEOUT', 30),
    
    'retry_attempts' => env('STREAM_RETRY_ATTEMPTS', 3),
    
    'retry_delay' => env('STREAM_RETRY_DELAY', 60),

    /*
    |--------------------------------------------------------------------------
    | Streaming Quality Settings
    |--------------------------------------------------------------------------
    |
    | Video quality settings for HLS streams
    |
    */
    
    'quality' => [
        'resolution' => env('STREAM_RESOLUTION', '720p'),
        'bitrate' => env('STREAM_BITRATE', '1500k'),
        'framerate' => env('STREAM_FRAMERATE', 25),
    ],

    /*
    |--------------------------------------------------------------------------
    | Monitoring Settings
    |--------------------------------------------------------------------------
    |
    | Settings for stream monitoring and auto-restart
    |
    */
    
    'monitoring' => [
        'enabled' => env('STREAM_MONITORING_ENABLED', true),
        'check_interval' => env('STREAM_CHECK_INTERVAL', 300), // 5 minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | Security settings for streaming
    |
    */
    
    'security' => [
        'token_expiry' => env('STREAM_TOKEN_EXPIRY', 3600), // 1 hour
        'allowed_origins' => explode(',', env('STREAM_ALLOWED_ORIGINS', '*')),
    ],

];
