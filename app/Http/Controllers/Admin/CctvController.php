<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cctv;
use App\Models\Location;
use Illuminate\Http\Request;

class CctvController extends Controller {
    public function index(Request $request) {
        $search = $request->get('search');
        
        $cctvs = Cctv::with('location')
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('location', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.cctvs.index', compact('cctvs'));
    }

    public function create() {
        $locations = Location::all();
        return view('admin.cctvs.create', compact('locations'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'rtsp_url' => 'nullable|url',
            'camera_type' => 'required|in:PTZ,Fix',
            'status' => 'required|in:Active,Inactive',
            'location_id' => 'required|exists:locations,id',
            'hls_url' => 'nullable|url',
        ]);

        Cctv::create($request->all());
        return redirect()->route('admin.cctvs.index')->with('success', 'CCTV created successfully.');
    }

    public function edit(Cctv $cctv) {
        $locations = Location::all();
        return view('admin.cctvs.edit', compact('cctv', 'locations'));
    }

    public function update(Request $request, Cctv $cctv) {
        $request->validate([
            'name' => 'required|string|max:255',
            'rtsp_url' => 'nullable|url',
            'camera_type' => 'required|in:PTZ,Fix',
            'status' => 'required|in:Active,Inactive',
            'location_id' => 'required|exists:locations,id',
            'hls_url' => 'nullable|url',
        ]);

        $cctv->update($request->all());
        return redirect()->route('admin.cctvs.index')->with('success', 'CCTV updated successfully.');
    }

    public function destroy(Cctv $cctv) {
        $cctv->delete();
        return redirect()->route('admin.cctvs.index')->with('success', 'CCTV deleted successfully.');
    }
}
