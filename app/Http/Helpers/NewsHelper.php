<?php

namespace App\Http\Helpers;

use App\Models\News;

class NewsHelper
{
    /**
     * Get news content with locations appended
     */
    public static function getContentWithLocations($news)
    {
        if (!$news) {
            return '';
        }

        $locations = $news->locations;
        
        if ($locations->isEmpty()) {
            return $news->content;
        }

        $locationNames = $locations->pluck('name')->implode(', ');
        
        // Check if content already ends with "Wilayah terdampak:"
        $content = trim($news->content);
        if (str_ends_with($content, 'Wilayah terdampak:')) {
            return $news->content . $locationNames;
        } elseif (str_ends_with($content, 'Wilayah terdampak: ')) {
            return $news->content . $locationNames;
        } else {
            return $news->content . ' Wilayah terdampak: ' . $locationNames;
        }
    }
}
