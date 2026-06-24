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
use App\Models\PrivateSectorDetails;


class PrivateSectorController extends Controller
{

 public function index()
{
    $privatesector = PrivateSectorDetails::latest()->get();

    // Pass data to the index view
    return view('backend.services.privatesector.index', compact('privatesector'));
}


     public function create(Request $request)
    { 
        return view('backend.services.privatesector.create');
    }









public function store(Request $request)
{
    $request->validate([
        'banner_image'          => 'required|mimes:jpg,jpeg,png,webp|max:10240',
        'main_image'            => 'required|mimes:jpg,jpeg,png,webp|max:10240',
        'heading'               => 'required|string|max:255',
        'description'           => 'required|string',
        'Acdemic_heading'       => 'required|string|max:255',
        'Acdemic_description'   => 'required|string',
    ]);

    // ================= Banner Upload =================
    $bannerName = time().'_banner.'.$request->banner_image->extension();
    $request->banner_image->move(public_path('PrivateSectorDetails/banner'), $bannerName);

    // ================= Main Image Upload =================
    $mainName = time().'_main.'.$request->main_image->extension();
    $request->main_image->move(public_path('PrivateSectorDetails/main'), $mainName);

    // ================= Store in DB =================
    PrivateSectorDetails::create([
        'banner_image'         => $bannerName,
        'main_image'           => $mainName,
        'heading'              => $request->heading,
        'description'          => $request->description,
        'academic_heading'     => $request->Acdemic_heading,
        'academic_description' => $request->Acdemic_description,
        'created_by'           => Auth::id(),
    ]);

    return redirect()->route('private-sectoracademic-details.index')
                     ->with('message', 'Data saved successfully');
}




   /* ==========================
        EDIT
    ========================== */
  public function edit($id)
{
    $privatesector = PrivateSectorDetails::findOrFail($id);

    return view('backend.services.privatesector.edit', compact('privatesector'));
}



public function update(Request $request, $id)
{
    $privatesector = PrivateSectorDetails::findOrFail($id);

    $request->validate([
        'banner_image'          => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'main_image'            => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'heading'               => 'required|string|max:255',
        'description'           => 'required|string',
        'Acdemic_heading'       => 'required|string|max:255',
        'Acdemic_description'   => 'required|string',
    ]);

    // ================= Banner Upload =================
    if ($request->hasFile('banner_image')) {

        // delete old
        if ($privatesector->banner_image && file_exists(public_path('PrivateSectorDetails/banner/'.$privatesector->banner_image))) {
            unlink(public_path('PrivateSectorDetails/banner/'.$privatesector->banner_image));
        }

        $bannerName = time().'_banner.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('PrivateSectorDetails/banner'), $bannerName);

    } else {
        $bannerName = $privatesector->banner_image;
    }

    // ================= Main Image Upload =================
    if ($request->hasFile('main_image')) {

        if ($privatesector->main_image && file_exists(public_path('PrivateSectorDetails/main/'.$privatesector->main_image))) {
            unlink(public_path('PrivateSectorDetails/main/'.$privatesector->main_image));
        }

        $mainName = time().'_main.'.$request->main_image->extension();
        $request->main_image->move(public_path('PrivateSectorDetails/main'), $mainName);

    } else {
        $mainName = $privatesector->main_image;
    }

    // ================= Update DB =================
    $privatesector->update([
        'banner_image'         => $bannerName,
        'main_image'           => $mainName,
        'heading'              => $request->heading,
        'description'          => $request->description,
        'academic_heading'     => $request->Acdemic_heading,
        'academic_description' => $request->Acdemic_description,
        'updated_by'           => Auth::id(),
    ]);

    return redirect()->route('private-sectoracademic-details.index')
                     ->with('message', 'Data updated successfully');
}




  public function destroy($id)
{
    $privatesector = PrivateSectorDetails::findOrFail($id);

    $privatesector->update([
        'deleted_by' => Auth::id(),
    ]);

    $privatesector->delete();   // ✅ FIXED HERE

    return redirect()->back()->with('message', 'Data deleted successfully');
}


}