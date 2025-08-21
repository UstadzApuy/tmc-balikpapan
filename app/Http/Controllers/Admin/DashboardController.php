<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Cctv;
use App\Models\Contact;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLocations = Location::count();
        $totalCctvs = Cctv::count();
        $totalContacts = Contact::count();
        $cctvsPerKecamatan = Location::select('kecamatan', \DB::raw('count(cctvs.id) as total_cctv'))
            ->leftJoin('cctvs', 'locations.id', '=', 'cctvs.location_id')
            ->groupBy('kecamatan')
            ->get();

        $news = News::with('locations')->where('is_active', true)->latest()->get();
        
        // Format news content with locations
        $news = $news->map(function ($newsItem) {
            $newsItem->display_content = $this->getContentWithLocations($newsItem);
            return $newsItem;
        });

        $locations = Location::all()->groupBy('kecamatan');

        return view('admin.dashboard', compact(
            'totalLocations',
            'totalCctvs',
            'totalContacts',
            'cctvsPerKecamatan',
            'news',
            'locations'
        ));
    }

    public function updateNews(Request $request)
    {
        // Get the selected news to check its title
        $news = News::find($request->news_id);
        $isTmcInfo = $news && $news->title === 'Informasi Aplikasi TMC Balikpapan';

        // Define validation rules
        $rules = [
            'news_id' => 'required|exists:news,id',
        ];

        // Only require scope and related fields if the news is not "Informasi Aplikasi TMC Balikpapan"
        if (!$isTmcInfo) {
            $rules['scope'] = 'required|in:city,kecamatan,area';
            $rules['kecamatan_id'] = 'required_if:scope,kecamatan|array';
            $rules['location_ids'] = 'required_if:scope,area|array';
            $rules['location_ids.*'] = 'exists:locations,id';
        }

        $request->validate($rules);

        // Clear previous session data
        session()->forget(['selected_news_id', 'selected_scope', 'selected_kecamatan', 'selected_locations']);
        
        // Set new session data
        session([
            'selected_news_id' => $request->news_id,
            'selected_scope' => $isTmcInfo ? null : $request->scope,
            'last_updated' => now()->timestamp
        ]);
        
        // Cache the selected news for global access
        cache([
            'selected_news_global' => $request->news_id,
            'selected_scope' => $isTmcInfo ? null : $request->scope,
            'last_updated' => now()->timestamp
        ]);
        
        if (!$isTmcInfo && $request->scope === 'kecamatan' && !empty($request->kecamatan_id)) {
            session(['selected_kecamatan' => $request->kecamatan_id]);
            cache(['selected_kecamatan' => $request->kecamatan_id]);
        } elseif (!$isTmcInfo && $request->scope === 'area' && !empty($request->location_ids)) {
            session(['selected_locations' => $request->location_ids]);
            cache(['selected_locations' => $request->location_ids]);
        }

        // Attach locations to news
        if ($news) {
            if ($isTmcInfo) {
                // Clear locations for "Informasi Aplikasi TMC Balikpapan"
                $news->locations()->sync([]);
            } elseif ($request->scope === 'area' && !empty($request->location_ids)) {
                $news->locations()->sync($request->location_ids);
            } elseif ($request->scope === 'kecamatan' && !empty($request->kecamatan_id)) {
                $locationIds = Location::whereIn('kecamatan', $request->kecamatan_id)->pluck('id');
                $news->locations()->sync($locationIds);
            } else {
                $news->locations()->sync([]);
            }
        }

        // Add cache invalidation timestamp
        cache()->forget('topbar_news_' . $request->news_id);
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Pilihan berita berhasil diperbarui.')
            ->with('script', '<script>
                sessionStorage.setItem("selected_news_id", ' . $request->news_id . ');
                sessionStorage.setItem("last_updated", ' . time() . ');
                window.dispatchEvent(new CustomEvent("newsUpdated", { detail: { newsId: ' . $request->news_id . ' } }));
            </script>');
    }

    /**
     * Get content with locations appended
     */
    private function getContentWithLocations(News $news)
    {
        if ($news->title === 'Informasi Aplikasi TMC Balikpapan') {
            return $news->content; // No locations for this news
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