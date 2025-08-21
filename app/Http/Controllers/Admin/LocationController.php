<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller {
    public function index(Request $request) {
        $search = $request->get('search');
        
        $locations = Location::withCount('cctvs')
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('kecamatan', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.locations.index', compact('locations'));
    }

    public function create() {
        return view('admin.locations.create');
    }

    public function store(Request $request) {
        $request->validate([
            'kecamatan' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Location::create($request->all());
        return redirect()->route('admin.locations.index')->with('success', 'Location created successfully.');
    }

    public function edit(Location $location) {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location) {
        $request->validate([
            'kecamatan' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $location->update($request->all());
        return redirect()->route('admin.locations.index')->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location) {
        $location->delete();
        return redirect()->route('admin.locations.index')->with('success', 'Location deleted successfully.');
    }
}
