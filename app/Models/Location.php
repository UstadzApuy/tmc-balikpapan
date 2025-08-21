<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model {
    use HasFactory;

    protected $fillable = ['kecamatan','name','latitude','longitude'];

    public function cctvs() {
        return $this->hasMany(Cctv::class);
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_location');
    }
}
