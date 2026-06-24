<?php

namespace App\Http\Controllers\Backend\Membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\MembershipRatesOptionDetails;


class MembershipRatesOptionController extends Controller
{

  public function index()
{
    $membershipsList = MembershipRatesOptionDetails::all();
return view('backend.memberships-pages.membershipratesoptions.index', compact('membershipsList'));

}


     public function create(Request $request)
    { 
        return view('backend.memberships-pages.membershipratesoptions.create');
    }











public function store(Request $request)
{
    /* ================= VALIDATION ================= */
    $request->validate([
        'banner_image'             => 'required|mimes:jpg,jpeg,png,webp|max:10240',
        'subscription_heading'     => 'required|string|max:255',
        'subscription_description' => 'required|string',
        'options'                  => 'required|array',
        'options.*.title'          => 'required|string|max:255',
        'options.*.description'    => 'required|string',
    ]);

    /* ================= IMAGE UPLOAD ================= */
    $bannerName = null;

    if ($request->hasFile('banner_image')) {
        $file = $request->file('banner_image');
        $bannerName = time() . '_banner.' . $file->getClientOriginalExtension();

        // store inside public/memberships/banner
        $file->move(public_path('memberships/banner'), $bannerName);
    }

    /* ================= OPTIONS JSON ================= */
    $optionsData = json_encode($request->options);

    /* ================= SAVE DATA ================= */
    MembershipRatesOptionDetails::create([
        'banner_image'            => $bannerName,
        'subscription_heading'    => $request->subscription_heading,
        'subscription_description'=> $request->subscription_description,
        'options'                 => $optionsData,
        'created_by'              => Auth::id(),
    ]);

    return redirect()
        ->route('membership-rates-details.index')
        ->with('message', 'Membership Rates Option saved successfully');
}





   /* ==========================
        EDIT
    ========================== */
  public function edit($id)
{
    $memberships = MembershipRatesOptionDetails::findOrFail($id);

    return view('backend.memberships-pages.membershipratesoptions.edit', compact('memberships'));
}


    /* ==========================
        UPDATE
    ========================== */
  

public function update(Request $request, $id)
{
    $memberships = MembershipRatesOptionDetails::findOrFail($id);

    $request->validate([
        'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'subscription_heading' => 'required|string|max:255',
        'subscription_description' => 'required|string',
        'options' => 'nullable|array',
        'options.*.title' => 'required|string|max:255',
        'options.*.description' => 'required|string',
    ]);

    // Handle banner deletion
    if($request->has('banner_delete') && $memberships->banner_image) {
        if(file_exists(public_path('memberships/banner/'.$memberships->banner_image))) {
            unlink(public_path('memberships/banner/'.$memberships->banner_image));
        }
        $bannerName = null;
    }
    // Handle banner upload
    elseif ($request->hasFile('banner_image')) {
        if ($memberships->banner_image && file_exists(public_path('memberships/banner/'.$memberships->banner_image))) {
            unlink(public_path('memberships/banner/'.$memberships->banner_image));
        }
        $bannerName = time().'_banner.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('memberships/banner'), $bannerName);
    } else {
        $bannerName = $memberships->banner_image;
    }

    // Handle options deletion
    $existingOptions = json_decode($memberships->options, true) ?? [];
    if($request->has('options_to_delete')) {
        foreach($request->options_to_delete as $delIndex) {
            unset($existingOptions[$delIndex]);
        }
    }

    // Merge updated/added options
    if($request->has('options')){
        foreach($request->options as $k => $opt){
            $existingOptions[$k] = $opt;
        }
    }

    $memberships->update([
        'banner_image' => $bannerName,
        'subscription_heading' => $request->subscription_heading,
        'subscription_description' => $request->subscription_description,
        'options' => json_encode(array_values($existingOptions)), // reindex array
        'updated_by' => Auth::id(),
    ]);

    return redirect()->route('membership-rates-details.index')
        ->with('message','Membership Rates Option updated successfully');
}




    /* ========================
        DELETE (Soft)
    ========================= */
    public function destroy($id)
    {
        $memberships = MembershipbenefitsDetails::findOrFail($id);

        $memberships->update([
            'deleted_by' => Auth::id(),
        ]);

        $memberships->delete();

        return redirect()->back()->with('message', 'Data deleted successfully');
    }


}