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
use App\Models\GeneralPracticeDetails;


class GeneralPracticeController extends Controller
{

  public function index()
{
    $generalpractice = GeneralPracticeDetails::latest()->get();

    return view('backend.services.generalpractice.index',
        compact('generalpractice'));
}


     public function create(Request $request)
    { 
        return view('backend.services.generalpractice.create');
    }







public function store(Request $request)
{
    $request->validate([
        'banner_image' => 'required|mimes:jpg,jpeg,png,webp|max:10240',
        'main_image'   => 'required|mimes:jpg,jpeg,png,webp|max:10240',
        'description'  => 'required|string',
        'benefits_heading'  => 'required|string',
        'benefits_description'  => 'required|string',

        'items.*.icon'        => 'required|mimes:jpg,jpeg,png,webp|max:2048',
        'items.*.heading'     => 'required|string|max:255',
        'items.*.description' => 'required|string',
    ]);

    /* ========================
        Banner Upload
    ======================== */
    $bannerName = time().'_banner.'.$request->banner_image->extension();
    $request->banner_image->move(public_path('generalpractice/banner'), $bannerName);

    /* ========================
        Main Image Upload
    ======================== */
    $mainImageName = time().'_main.'.$request->main_image->extension();
    $request->main_image->move(public_path('generalpractice/main'), $mainImageName);

    /* ========================
        Prepare Items JSON Array
    ======================== */
    $itemsData = [];

    if ($request->has('items')) {

        foreach ($request->items as $key => $item) {

            $iconName = time().'_'.$key.'.'.$item['icon']->extension();
            $item['icon']->move(public_path('generalpractice/icons'), $iconName);

            $itemsData[] = [
                'icon'        => $iconName,
                'heading'     => $item['heading'],
                'description' => $item['description'],
            ];
        }
    }

    /* ========================
        Store in Single Table
    ======================== */
    GeneralPracticeDetails::create([
        'banner_image' => $bannerName,
        'main_image'   => $mainImageName,
        'description'  => $request->description,
        'benefits_heading'  => $request->benefits_heading,
        'benefits_description'  => $request->benefits_description,
        'items'        => $itemsData, // stored as JSON
        'created_by'   => Auth::id(),
    ]);

    return redirect()
        ->route('general-practice-details.index')
        ->with('message','Data saved successfully');
}




   /* ==========================
        EDIT
    ========================== */
  public function edit($id)
{
    $generalpractice = GeneralPracticeDetails::findOrFail($id);

    return view('backend.services.generalpractice.edit', compact('generalpractice'));
}


    /* ==========================
        UPDATE
    ========================== */
  

public function update(Request $request, $id)
{
    $generalpractice = GeneralPracticeDetails::findOrFail($id);

    $request->validate([
        'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'main_image'   => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'description'  => 'required|string',
                'benefits_heading'  => 'required|string',
        'benefits_description'  => 'required|string',


        'items.*.icon'        => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
        'items.*.heading'     => 'required|string|max:255',
        'items.*.description' => 'required|string',
    ]);

    /* ========================
        Banner Upload
    ======================== */
    if ($request->hasFile('banner_image')) {

        if ($generalpractice->banner_image &&
            file_exists(public_path('generalpractice/banner/'.$generalpractice->banner_image))) {

            unlink(public_path('generalpractice/banner/'.$generalpractice->banner_image));
        }

        $bannerName = time().'_banner.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('generalpractice/banner'), $bannerName);

    } else {
        $bannerName = $generalpractice->banner_image;
    }

    /* ========================
        Main Image Upload
    ======================== */
    if ($request->hasFile('main_image')) {

        if ($generalpractice->main_image &&
            file_exists(public_path('generalpractice/main/'.$generalpractice->main_image))) {

            unlink(public_path('generalpractice/main/'.$generalpractice->main_image));
        }

        $mainImageName = time().'_main.'.$request->main_image->extension();
        $request->main_image->move(public_path('generalpractice/main'), $mainImageName);

    } else {
        $mainImageName = $generalpractice->main_image;
    }

    /* ========================
        Prepare Items JSON Array
    ======================== */
    $itemsData = [];

    if ($request->has('items')) {

        foreach ($request->items as $key => $item) {

            // If new icon uploaded
            if (isset($item['icon']) && $item['icon'] instanceof \Illuminate\Http\UploadedFile) {

                $iconName = time().'_'.$key.'.'.$item['icon']->extension();
                $item['icon']->move(public_path('generalpractice/icons'), $iconName);

            } else {
                // keep old icon if sent hidden
                $iconName = $item['old_icon'] ?? null;
            }

            $itemsData[] = [
                'icon'        => $iconName,
                'heading'     => $item['heading'],
                'description' => $item['description'],
            ];
        }
    }

    /* ========================
        Update Main Record
    ======================== */
    $generalpractice->update([
        'banner_image' => $bannerName,
        'main_image'   => $mainImageName,
        'description'  => $request->description,
        'benefits_heading'  => $request->benefits_heading,
        'benefits_description'  => $request->benefits_description,
        'items'        => $itemsData,
        'updated_by'   => Auth::id(),
    ]);

    return redirect()
        ->route('general-practice-details.index')
        ->with('message', 'Data updated successfully');
}




    /* ========================
        DELETE (Soft)
    ========================= */
    public function destroy($id)
    {
        $generalpractice = GeneralPracticeDetails::findOrFail($id);

        $generalpractice->update([
            'deleted_by' => Auth::id(),
        ]);

        $generalpractice->delete();

        return redirect()->back()->with('message', 'Data deleted successfully');
    }


}