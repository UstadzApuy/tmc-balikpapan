<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cctv extends Model {
    use HasFactory;

    protected $fillable = [
        'name','rtsp_url','camera_type','status','location_id','hls_url'
    ];

    public function location() {
        return $this->belongsTo(Location::class);
    }
}