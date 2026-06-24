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
use App\Models\ForNonMembershipDetails;


class ForNonMembershipController extends Controller
{

   public function index()
{
    $fornonmembers = ForNonMembershipDetails::latest()->get();

    return view('backend.services.fornonmembers.index', compact('fornonmembers'));
}


     public function create(Request $request)
    { 
        return view('backend.services.fornonmembers.create');
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
    $request->banner_image->move(public_path('/fornonmembers/banner'), $bannerName);

    // Main Image Upload
    $mainImageName = time().'_main.'.$request->main_image->extension();
    $request->main_image->move(public_path('/fornonmembers/main'), $mainImageName);

    // Store Data
    ForNonMembershipDetails::create([
        'banner_image' => $bannerName,
        'main_image'   => $mainImageName,
        'heading'  => $request->heading,
        'description'  => $request->description,
        'created_by'   => Auth::id(),
    ]);

    return redirect()->route('for-non-members-details.index')
        ->with('message','Data saved successfully');
}



   /* ==========================
        EDIT
    ========================== */
    public function edit($id)
    {
        $fornonmembers = ForNonMembershipDetails::findOrFail($id);

        return view('backend.services.fornonmembers.edit', compact('fornonmembers'));
    }

    /* ==========================
        UPDATE
    ========================== */
  

public function update(Request $request, $id)
{
    $fornonmembers = ForNonMembershipDetails::findOrFail($id);

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

        if ($fornonmembers->banner_image &&
            file_exists(public_path('fornonmembers/banner/'.$fornonmembers->banner_image))) {

            unlink(public_path('fornonmembers/banner/'.$fornonmembers->banner_image));
        }

        $bannerName = time().'_banner.'.$fornonmembers->banner_image->extension();
        $request->banner_image->move(public_path('fornonmembers/banner'), $bannerName);

    } else {
        $bannerName = $dentists->banner_image;
    }

    /* ========================
        Main Image Update
    ======================== */
    if ($request->hasFile('main_image')) {

        if ($dentists->main_image &&
            file_exists(public_path('fornonmembers/main/'.$fornonmembers->main_image))) {

            unlink(public_path('fornonmembers/main/'.$fornonmembers->main_image));
        }

        $mainImageName = time().'_main.'.$request->main_image->extension();
        $request->main_image->move(public_path('fornonmembers/main'), $mainImageName);

    } else {
        $mainImageName = $fornonmembers->main_image;
    }

    /* ========================
        Update Data
    ======================== */
    $fornonmembers->update([
        'banner_image' => $bannerName,
        'main_image'   => $mainImageName,
         'heading'  => $request->heading,
        'description'  => $request->description,
        'updated_by'   => Auth::id(),
    ]);

    return redirect()
            ->route('for-non-members-details.index')
            ->with('message', 'Data updated successfully');
}


    /* ========================
        DELETE (Soft)
    ========================= */
    public function destroy($id)
    {
        $fornonmembers = ForNonMembershipDetails::findOrFail($id);

        $fornonmembers->update([
            'deleted_by' => Auth::id(),
        ]);

        $fornonmembers->delete();

        return redirect()->back()->with('message', 'Data deleted successfully');
    }


}