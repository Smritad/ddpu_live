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
use App\Models\MembershipDetail;


class membershipController extends Controller
{

   public function index()
{
    $memberships = MembershipDetail::latest()->get();
    return view('backend.services.membership.index', compact('memberships'));
}


     public function create(Request $request)
    { 
        return view('backend.services.membership.create');
    }




public function store(Request $request)
{
    $request->validate([
        'banner_image' => 'required|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'title' => 'required',
        'items.*.image' => 'required|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'items.*.heading' => 'required',
        'items.*.description' => 'required',
    ]);

    // ================= Banner Upload =================
    $bannerName = time().'_banner.'.$request->banner_image->extension();
    $request->banner_image->move(public_path('/membership/banner'), $bannerName);

    // ================= Items Upload =================
    $itemsData = [];

    foreach ($request->items as $key => $item) {

        $imageName = time().'_'.$key.'.'.$item['image']->extension();
        $item['image']->move(public_path('/membership/items'), $imageName);

        $itemsData[] = [
            'image' => $imageName,
            'heading' => $item['heading'],
            'description' => $item['description'],
        ];
    }

    // ================= Store Data =================
    MembershipDetail::create([
        'banner_image' => $bannerName,
        'title' => $request->title,
        'items' => json_encode($itemsData),
        'created_by' => Auth::id(), // Logged in user ID
    ]);

    return redirect()->route('membership-details.index')
        ->with('success','Data saved successfully');
}


   /* ==========================
        EDIT
    ========================== */
    public function edit($id)
    {
        $membership = MembershipDetail::findOrFail($id);

        return view('backend.services.membership.edit', compact('membership'));
    }

    /* ==========================
        UPDATE
    ========================== */
  

public function update(Request $request, $id)
{
    $membership = MembershipDetail::findOrFail($id);

    $request->validate([
        'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'title' => 'required',
        'items.*.image' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'items.*.heading' => 'required',
        'items.*.description' => 'required',
    ]);

    /* ========================
        Banner Update
    ======================== */
    if ($request->hasFile('banner_image')) {

        // delete old banner
        if ($membership->banner_image && file_exists(public_path('/membership/banner/'.$membership->banner_image))) {
            unlink(public_path('/membership/banner/'.$membership->banner_image));
        }

        $bannerName = time().'_banner.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('/membership/banner'), $bannerName);

    } else {
        $bannerName = $membership->banner_image;
    }

    /* ========================
        Items Update
    ======================== */
    $oldItems = json_decode($membership->items, true);
    $itemsData = [];

    foreach ($request->items as $key => $item) {

        // If new image uploaded
        if (isset($item['image']) && $item['image'] instanceof \Illuminate\Http\UploadedFile) {

            // delete old image if exists
            if (isset($oldItems[$key]['image']) && 
                file_exists(public_path('/membership/items/'.$oldItems[$key]['image']))) {
                unlink(public_path('/membership/items/'.$oldItems[$key]['image']));
            }

            $imageName = time().'_'.$key.'.'.$item['image']->extension();
            $item['image']->move(public_path('/membership/items'), $imageName);

        } else {
            // keep old image
            $imageName = $oldItems[$key]['image'] ?? null;
        }

        $itemsData[] = [
            'image' => $imageName,
            'heading' => $item['heading'],
            'description' => $item['description'],
        ];
    }

    /* ========================
        Update Data
    ======================== */
    $membership->update([
        'banner_image' => $bannerName,
        'title' => $request->title,
        'items' => json_encode($itemsData),
        'updated_by' => Auth::id(),
    ]);

    return redirect()
            ->route('membership-details.index')
            ->with('success', 'Data updated successfully');
}

    /* ========================
        DELETE (Soft)
    ========================= */
    public function destroy($id)
    {
        $membership = MembershipDetail::findOrFail($id);

        $membership->update([
            'deleted_by' => Auth::id(),
        ]);

        $membership->delete();

        return redirect()->back()->with('message', 'Data deleted successfully');
    }


}