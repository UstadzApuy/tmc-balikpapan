<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cctv;
use Illuminate\Http\Request;

class CctvController extends Controller
{
    public function show($id)
    {
        $cctv = Cctv::with('location')->findOrFail($id);
        return view('cctv.show', compact('cctv'));
    }

    public function modal($id)
    {
        $cctv = Cctv::with('location')->findOrFail($id);
        return view('cctv.modal', compact('cctv'));
    }

    public function streaming()
    {
        // This method might be deprecated in favor of StreamingController
        return redirect()->route('streaming');
    }
}
