<?php

namespace App\Http\Controllers\Backend\aboutus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\WhatIsDdpu;


class WhatDDPUDetailsController extends Controller
{

   public function index()
    {
    $ddpuList = WhatIsDdpu::whereNull('deleted_by')
                ->latest()
                ->get();

    return view(
        'backend.about-page.what-is-ddpu-details.index',
        compact('ddpuList')
    );
}

     public function create(Request $request)
    { 
        return view('backend.about-page.what-is-ddpu-details.create');
    }



    /* ========================
        STORE
    ========================= */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'banner_image' => 'required|mimes:jpg,jpeg,png,webp,svg|max:10240',
            'gallery_images.*' => 'mimes:jpg,jpeg,png,webp,svg|max:10240',
        ]);

        $bannerName = null;

        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $bannerName = time().'_banner.'.$image->getClientOriginalExtension();
            $image->move(public_path('/whatddpu/banner'), $bannerName);
        }

        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $img) {
                $imgName = time().'_'.uniqid().'.'.$img->getClientOriginalExtension();
                $img->move(public_path('/whatddpu/banner'), $imgName);
                $galleryImages[] = $imgName;
            }
        }

        WhatIsDdpu::create([
            'title' => $request->title,
            'banner_image' => $bannerName,
            'gallery_images' => $galleryImages,
            'professional_description' => $request->professional_description,
            'compare_description' => $request->compare_description,
            'created_by' => Auth::id(),
        ]);
        return redirect()->route('what-is-ddpu-details.index')->with('message', 'Data saved successfully');
    }

   /* ==========================
        EDIT
    ========================== */
    public function edit($id)
    {
        $ddpu = WhatIsDdpu::findOrFail($id);

        return view('backend.about-page.what-is-ddpu-details.edit', compact('ddpu'));
    }

    /* ==========================
        UPDATE
    ========================== */
    public function update(Request $request, $id)
    {
        $ddpu = WhatIsDdpu::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:10240',
            'gallery_images.*' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:10240',
        ]);

        /* ========================
            Banner Image Update
        ======================== */
        if ($request->hasFile('banner_image')) {

            // delete old banner
            if ($ddpu->banner_image && file_exists(public_path('whatddpu/banner/'.$ddpu->banner_image))) {
                unlink(public_path('whatddpu/banner/'.$ddpu->banner_image));
            }

            $image = $request->file('banner_image');
            $bannerName = time().'_banner.'.$image->getClientOriginalExtension();
            $image->move(public_path('whatddpu/banner'), $bannerName);
            $ddpu->banner_image = $bannerName;
        }

        /* ========================
            Gallery Images Update
        ======================== */
        if ($request->hasFile('gallery_images')) {

            // delete old gallery images
            if ($ddpu->gallery_images) {
                foreach ($ddpu->gallery_images as $old) {
                    if (file_exists(public_path('whatddpu/banner/'.$old))) {
                        unlink(public_path('whatddpu/banner/'.$old));
                    }
                }
            }

            $galleryImages = [];
            foreach ($request->file('gallery_images') as $img) {
                $imgName = time().'_'.uniqid().'.'.$img->getClientOriginalExtension();
                $img->move(public_path('whatddpu/banner'), $imgName);
                $galleryImages[] = $imgName;
            }

            $ddpu->gallery_images = $galleryImages;
        }

        /* ========================
            Update Other Fields
        ======================== */
        $ddpu->update([
            'title' => $request->title,
            'professional_description' => $request->professional_description,
            'compare_description' => $request->compare_description,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
                ->route('what-is-ddpu-details.index')
                ->with('message', 'Data updated successfully');
    }

    /* ========================
        DELETE (Soft)
    ========================= */
    public function destroy($id)
    {
        $ddpu = WhatIsDdpu::findOrFail($id);

        $ddpu->update([
            'deleted_by' => Auth::id(),
        ]);

        $ddpu->delete();

        return redirect()->back()->with('message', 'Data deleted successfully');
    }


}