<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'weather_condition',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'news_location');
    }

    /**
     * Get content with locations appended
     */
    public function getContentWithLocations()
    {
        $locations = $this->locations;
        
        if ($locations->isEmpty()) {
            return $this->content;
        }

        $locationNames = $locations->pluck('name')->implode(', ');
        
        // Check if content already ends with "Wilayah terdampak:"
        if (str_ends_with(trim($this->content), 'Wilayah terdampak:')) {
            return $this->content . $locationNames;
        } elseif (str_ends_with(trim($this->content), 'Wilayah terdampak: ')) {
            return $this->content . $locationNames;
        } else {
            // If no "Wilayah terdampak:" found, append it
            return $this->content . ' Wilayah terdampak: ' . $locationNames;
        }
    }

    /**
     * Get content with locations for display
     */
    public function getDisplayContent()
    {
        return $this->getContentWithLocations();
    }
}
