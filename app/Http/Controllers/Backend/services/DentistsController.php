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
use App\Models\DentistsDetails;


class dentistsController extends Controller
{

   public function index()
{
    $dentists = DentistsDetails::latest()->get();

    return view('backend.services.dentists.index', compact('dentists'));
}


     public function create(Request $request)
    { 
        return view('backend.services.dentists.create');
    }






public function store(Request $request)
{
    $request->validate([
        'banner_image' => 'required|mimes:jpg,jpeg,png,webp|max:10240',
        'main_image'   => 'required|mimes:jpg,jpeg,png,webp|max:10240',
        'description'  => 'required|string',
        'heading'  => 'required|string',
    ]);

    // Banner Upload
    $bannerName = time().'_banner.'.$request->banner_image->extension();
    $request->banner_image->move(public_path('/dentists/banner'), $bannerName);

    // Main Image Upload
    $mainImageName = time().'_main.'.$request->main_image->extension();
    $request->main_image->move(public_path('/dentists/main'), $mainImageName);

    // Store Data
    DentistsDetails::create([
        'banner_image' => $bannerName,
        'main_image'   => $mainImageName,
        'heading'  => $request->heading,
        'description'  => $request->description,
        'created_by'   => Auth::id(),
    ]);

    return redirect()->route('dentists-details.index')
        ->with('message','Data saved successfully');
}



   /* ==========================
        EDIT
    ========================== */
    public function edit($id)
    {
        $dentists = DentistsDetails::findOrFail($id);

        return view('backend.services.dentists.edit', compact('dentists'));
    }

    /* ==========================
        UPDATE
    ========================== */
  

public function update(Request $request, $id)
{
    $dentists = DentistsDetails::findOrFail($id);

    $request->validate([
        'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'main_image'   => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'description'  => 'required|string',
        'heading'  => 'required|string',
    ]);

    /* ========================
        Banner Update
    ======================== */
    if ($request->hasFile('banner_image')) {

        if ($dentists->banner_image &&
            file_exists(public_path('dentists/banner/'.$dentists->banner_image))) {

            unlink(public_path('dentists/banner/'.$dentists->banner_image));
        }

        $bannerName = time().'_banner.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('dentists/banner'), $bannerName);

    } else {
        $bannerName = $dentists->banner_image;
    }

    /* ========================
        Main Image Update
    ======================== */
    if ($request->hasFile('main_image')) {

        if ($dentists->main_image &&
            file_exists(public_path('dentists/main/'.$dentists->main_image))) {

            unlink(public_path('dentists/main/'.$dentists->main_image));
        }

        $mainImageName = time().'_main.'.$request->main_image->extension();
        $request->main_image->move(public_path('dentists/main'), $mainImageName);

    } else {
        $mainImageName = $dentists->main_image;
    }

    /* ========================
        Update Data
    ======================== */
    $dentists->update([
        'banner_image' => $bannerName,
        'main_image'   => $mainImageName,
         'heading'  => $request->heading,
        'description'  => $request->description,
        'updated_by'   => Auth::id(),
    ]);

    return redirect()
            ->route('dentists-details.index')
            ->with('message', 'Data updated successfully');
}


    /* ========================
        DELETE (Soft)
    ========================= */
    public function destroy($id)
    {
        $dentists = DentistsDetails::findOrFail($id);

        $dentists->update([
            'deleted_by' => Auth::id(),
        ]);

        $dentists->delete();

        return redirect()->back()->with('message', 'Data deleted successfully');
    }


}