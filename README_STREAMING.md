
# CCTV Streaming System Documentation

## Overview
This system provides RTSP to HLS conversion for CCTV cameras using FFmpeg, integrated with the existing Laravel TMC Balikpapan application.

## Features
- RTSP to HLS conversion using FFmpeg
- Background job processing with Laravel Queue
- Real-time stream monitoring and auto-restart
- RESTful API for stream management
- Integration with existing CCTV database
- Support for multiple camera types (PTZ, Fixed)

## Architecture

### Components
1. **StreamingService** - Core service for FFmpeg operations
2. **ProcessCctvStream** - Background job for stream processing
3. **Console Commands** - CLI tools for stream management
4. **API Controllers** - RESTful endpoints for stream control
5. **Database Migration** - Additional fields for streaming status

### Directory Structure
```
public/streams/hls/
├── cctv_1/
│   ├── playlist.m3u8
│   ├── segment_000.ts
│   └── segment_001.ts
├── cctv_2/
│   └── ...
└── .htaccess
```

## Installation

### 1. Setup Streaming Infrastructure
```bash
php artisan streaming:setup
```

### 2. Install FFmpeg
```bash
php artisan ffmpeg:install
```

### 3. Run Database Migration
```bash
php artisan migrate
```

### 4. Configure Environment
Add to your `.env` file:
```env
FFMPEG_PATH=ffmpeg
HLS_SEGMENT_DURATION=4
HLS_MAX_SEGMENTS=50
STREAM_TIMEOUT=30
STREAM_MONITORING_ENABLED=true
STREAM_CHECK_INTERVAL=300
```

## Usage

### Start All Streams
```bash
php artisan cctv:streams:start --all
```

### Start Specific Streams
```bash
php artisan cctv:streams:start --ids=1,2,3
```

### Stop All Streams
```bash
php artisan cctv:streams:stop --all
```

### Monitor Streams
```bash
php artisan cctv:streams:monitor
```

### Check Stream Status
```bash
# Via API
GET /api/streaming/status
GET /api/streaming/status/{id}

# Via CLI
php artisan tinker
>>> $service = app(\App\Services\StreamingService::class);
>>> $service->isStreamActive(\App\Models\Cctv::find(1));
```

## API Endpoints

### Streaming Management
- `GET /api/streaming/status` - Get all stream statuses
- `GET /api/streaming/status/{id}` - Get specific stream status
- `POST /api/streaming/start/{id}` - Start streaming for CCTV
- `POST /api/streaming/stop/{id}` - Stop streaming for CCTV

### CCTV Management
- `GET /api/cctv` - List all CCTVs
- `GET /api/cctv/{id}` - Get specific CCTV
- `GET /api/cctv/location/{locationId}` - Get CCTVs by location

## Integration with Views

### Map View (`resources/views/partials/map.blade.php`)
The map view automatically uses HLS URLs when available:
- If `hls_url` is present, it displays the HLS stream
- If only `rtsp_url` is present, it shows RTSP info
- Streams are displayed in draggable popup windows

### Streaming View (`resources/views/partials/streaming.blade.php`)
The streaming view lists all CCTVs grouped by location:
- Each CCTV shows streaming status
- "Live" button opens the stream in a popup
- Integration with Video.js for HLS playback

## FFmpeg Command Details

The system uses the following FFmpeg command for RTSP to HLS conversion:
```bash
ffmpeg -i [RTSP_URL] \
  -c:v libx264 -preset veryfast -tune zerolatency \
  -c:a aac -b:a 128k \
  -f hls -hls_time 4 -hls_list_size 50 \
  -hls_flags delete_segments \
  -hls_segment_filename segment_%03d.ts \
  playlist.m3u8
```

## Monitoring and Maintenance

### Automatic Monitoring
- Streams are monitored every 5 minutes (configurable)
- Failed streams are automatically restarted
- Logs are written to Laravel's log system

### Manual Monitoring
```bash
# Check active processes
ps aux | grep ffmpeg

# Check HLS files
ls -la public/streams/hls/

# Check logs
tail -f storage/logs/laravel.log
```

## Troubleshooting

### Common Issues

1. **FFmpeg not found**
   - Run `php artisan ffmpeg:install`
   - Ensure FFmpeg is in system PATH

2. **Permission denied**
   - Ensure web server has write access to `public/streams/hls/`
   - Run `chmod -R 755 public/streams/`

3. **Stream not starting**
   - Check RTSP URL accessibility
   - Verify network connectivity
   - Check Laravel logs for FFmpeg errors

4. **HLS files not accessible**
   - Check .htaccess configuration
   - Verify web server configuration for .m3u8 and .ts files

### Debug Commands
```bash
# Test FFmpeg installation
ffmpeg -version

# Test RTSP URL
ffplay [RTSP_URL]

# Check stream status
php artisan tinker
>>> $cctv = \App\Models\Cctv::find(1);
>>> $service = app(\App\Services\StreamingService::class);
>>> $service->isStreamActive($cctv);
```

## Performance Considerations

- Each stream uses approximately 50-100MB RAM
- CPU usage depends on resolution and frame rate
- Consider using hardware acceleration for better performance
- Monitor disk space for HLS segments

## Security

- HLS segments are served with appropriate CORS headers
- Direct access to segment files is controlled via .htaccess
- Consider implementing token-based authentication for production

## Future Enhancements

- Multi-bitrate streaming (adaptive bitrate)
- Stream recording capabilities
- WebRTC support for lower latency
- Advanced analytics and monitoring dashboard
