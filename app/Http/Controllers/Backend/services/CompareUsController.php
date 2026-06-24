<?php

namespace App\Http\Controllers\Backend\services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\CompareUsDetails;


class CompareUsController extends Controller
{

 public function index()
{
    $compareus = CompareUsDetails::latest()->get();

    // Pass data to the index view
    return view('backend.services.compareus.index', compact('compareus'));
   
}


     public function create(Request $request)
    { 
        return view('backend.services.compareus.create');
    }









public function store(Request $request)
{
    $request->validate([
        'banner_image'   => 'required|mimes:jpg,jpeg,png,webp|max:10240',
        'heading'        => 'required|string|max:255',
        'columns'        => 'required|array',
        'rows'           => 'required|array',
    ]);

    // Upload Banner
    $bannerName = null;
    if ($request->hasFile('banner_image')) {
        $bannerName = time().'_banner.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('compareus/banner'), $bannerName);
    }

    // Prepare JSON
    $details = [
        'columns' => $request->columns,
        'rows'    => $request->rows,
    ];

    // Save
    CompareUsDetails::create([
        'banner_image' => $bannerName,
        'heading'      => $request->heading,
        'details'      => $details,
        'created_by'   => Auth::id(),
    ]);

    return redirect()->route('compare-us-details.index')
                     ->with('message', 'Data saved successfully');
}





   /* ==========================
        EDIT
    ========================== */
  public function edit($id)
{
    $compareus = CompareUsDetails::findOrFail($id);

    return view('backend.services.compareus.edit', compact('compareus'));
}



public function update(Request $request, $id)
{
    $compareus = CompareUsDetails::findOrFail($id);

    $request->validate([
        'banner_image'   => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'heading'        => 'required|string|max:255',
        'columns'        => 'required|array',
        'rows'           => 'required|array',
    ]);

    // Banner upload
    if ($request->hasFile('banner_image')) {

        if ($compareus->banner_image && file_exists(public_path('compareus/banner/'.$compareus->banner_image))) {
            unlink(public_path('compareus/banner/'.$compareus->banner_image));
        }

        $bannerName = time().'_banner.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('compareus/banner'), $bannerName);

    } else {
        $bannerName = $compareus->banner_image;
    }

    // JSON structure
    $details = [
        'columns' => $request->columns,
        'rows'    => $request->rows,
    ];

    // Update
    $compareus->update([
        'banner_image' => $bannerName,
        'heading'      => $request->heading,
        'details'      => $details,
        'updated_by'   => Auth::id(),
    ]);

    return redirect()->route('compare-us-details.index')
        ->with('message', 'Data updated successfully');
}





  public function destroy($id)
{
    $compareus = CompareUsDetails::findOrFail($id);

    $compareus->update([
        'deleted_by' => Auth::id(),
    ]);

    $compareus->delete();   // ✅ FIXED HERE

    return redirect()->back()->with('message', 'Data deleted successfully');
}


}