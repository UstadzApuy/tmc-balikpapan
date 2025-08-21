<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Location;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('locations')->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $locations = Location::all()->groupBy('kecamatan');
        return view('admin.news.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'weather_condition' => 'required|in:hujan,banjir,kemacetan,kepadatan,normal,info',
            'locations' => 'array',
            'locations.*' => 'exists:locations,id',
        ]);

        $news = News::create([
            'title' => $request->title,
            'content' => $request->content,
            'weather_condition' => $request->weather_condition,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->has('locations')) {
            $news->locations()->sync($request->locations);
        }

        return redirect()->route('admin.news.index')->with('success', 'News created successfully.');
    }

    public function edit(News $news)
    {
        $locations = Location::all()->groupBy('kecamatan');
        $news->load('locations');
        return view('admin.news.edit', compact('news', 'locations'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'weather_condition' => 'required|in:hujan,banjir,kemacetan,kepadatan,normal,info',
            'locations' => 'array',
            'locations.*' => 'exists:locations,id',
        ]);

        $news->update([
            'title' => $request->title,
            'content' => $request->content,
            'weather_condition' => $request->weather_condition,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->has('locations')) {
            $news->locations()->sync($request->locations);
        } else {
            $news->locations()->detach();
        }

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }

    public function toggleStatus(News $news)
    {
        $news->update(['is_active' => !$news->is_active]);
        return redirect()->route('admin.news.index')->with('success', 'News status updated.');
    }
}
