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
use App\Models\TrustGradeDetails;


class TrustGradeHocAppointeesNHSController extends Controller
{

 public function index()
{
    $trustgradedetails = TrustGradeDetails::latest()->get();

    // Pass data to the index view
    return view('backend.services.trustgrade.index', compact('trustgradedetails'));
}


     public function create(Request $request)
    { 
        return view('backend.services.trustgrade.create');
    }







public function store(Request $request)
{
    $request->validate([
        'banner_image' => 'required|mimes:jpg,jpeg,png,webp|max:10240',
        'heading'      => 'required|string|max:255',
        'title.*'      => 'required|string|max:255',
        'description.*'=> 'nullable|string',
    ]);

    // Upload Banner
    $bannerName = time().'_banner.'.$request->banner_image->extension();
    $request->banner_image->move(public_path('TrustGradeDetails/banner'), $bannerName);

    // Prepare multiple title & description
    $details = [];
    if ($request->has('title')) {
        foreach ($request->title as $index => $title) {
            $details[] = [
                'title'       => $title,
                'description' => $request->description[$index] ?? '',
            ];
        }
    }

    // Store in DB
    TrustGradeDetails::create([
        'banner_image' => $bannerName,
        'heading'      => $request->heading,
        'details'      => $details,
        'created_by'   => auth()->id(),
    ]);

    return redirect()->route('trust-grade-details.index')
                     ->with('message', 'Data saved successfully');
}




   /* ==========================
        EDIT
    ========================== */
  public function edit($id)
{
    $trustgradedetails = TrustGradeDetails::findOrFail($id);

    return view('backend.services.trustgrade.edit', compact('trustgradedetails'));
}

public function update(Request $request, $id)
{
    $TrustGradeDetails = TrustGradeDetails::findOrFail($id);

    $request->validate([
        'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'heading'      => 'required|string|max:255',
        'title.*'      => 'required|string|max:255',
        'description.*'=> 'nullable|string',
    ]);

    // Upload Banner if new
    if ($request->hasFile('banner_image')) {
        if ($TrustGradeDetails->banner_image && file_exists(public_path('TrustGradeDetails/banner/'.$TrustGradeDetails->banner_image))) {
            unlink(public_path('TrustGradeDetails/banner/'.$TrustGradeDetails->banner_image));
        }
        $bannerName = time().'_banner.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('TrustGradeDetails/banner'), $bannerName);
    } else {
        $bannerName = $TrustGradeDetails->banner_image;
    }

    // Prepare multiple title & description
    $details = [];
    if ($request->has('title')) {
        foreach ($request->title as $index => $title) {
            $details[] = [
                'title'       => $title,
                'description' => $request->description[$index] ?? '',
            ];
        }
    }

    // Update record
    $TrustGradeDetails->update([
        'banner_image' => $bannerName,
        'heading'      => $request->heading,
        'details'      => $details,
        'updated_by'   => auth()->id(),
    ]);

    return redirect()->route('trust-grade-details.index')
                     ->with('message', 'Data updated successfully');
}




  public function destroy($id)
{
    $TrustGradeDetails = TrustGradeDetails::findOrFail($id);

    $TrustGradeDetails->update([
        'deleted_by' => Auth::id(),
    ]);

    $TrustGradeDetails->delete();   // ✅ FIXED HERE

    return redirect()->back()->with('message', 'Data deleted successfully');
}


}