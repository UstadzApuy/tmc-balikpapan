<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Contact;

class HomeController extends Controller {
    public function index() {
        $locations = Location::with('cctvs')->get();
        $groupedByKecamatan = $locations->groupBy('kecamatan');
        
        // Use actual Contact model data from database instead of hardcoded array
        $contacts = Contact::orderBy('order')->get();

        return view('index', compact('locations', 'groupedByKecamatan', 'contacts'));
    }
}
