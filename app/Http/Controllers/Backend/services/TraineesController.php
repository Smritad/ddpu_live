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
use App\Models\TraineesDetail;


class TraineesController extends Controller
{

 public function index()
{
    $traineesdetail = TraineesDetail::latest()->get();

    // Pass data to the index view
    return view('backend.services.traineesdetail.index', compact('traineesdetail'));
}


     public function create(Request $request)
    { 
        return view('backend.services.traineesdetail.create');
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
    $request->banner_image->move(public_path('traineesdetail/banner'), $bannerName);

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
    TraineesDetail::create([
        'banner_image' => $bannerName,
        'heading'      => $request->heading,
        'details'      => $details,
        'created_by'   => auth()->id(),
    ]);

    return redirect()->route('trainees-details.index')
                     ->with('message', 'Data saved successfully');
}




   /* ==========================
        EDIT
    ========================== */
  public function edit($id)
{
    $traineesdetail = TraineesDetail::findOrFail($id);

    return view('backend.services.traineesdetail.edit', compact('traineesdetail'));
}

public function update(Request $request, $id)
{
    $traineesdetail = TraineesDetail::findOrFail($id);

    $request->validate([
        'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'heading'      => 'required|string|max:255',
        'title.*'      => 'required|string|max:255',
        'description.*'=> 'nullable|string',
    ]);

    // Upload Banner if new
    if ($request->hasFile('banner_image')) {
        if ($traineesdetail->banner_image && file_exists(public_path('traineesdetail/banner/'.$traineesdetail->banner_image))) {
            unlink(public_path('traineesdetail/banner/'.$traineesdetail->banner_image));
        }
        $bannerName = time().'_banner.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('traineesdetail/banner'), $bannerName);
    } else {
        $bannerName = $traineesdetail->banner_image;
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
    $traineesdetail->update([
        'banner_image' => $bannerName,
        'heading'      => $request->heading,
        'details'      => $details,
        'updated_by'   => auth()->id(),
    ]);

    return redirect()->route('trainees-details.index')
                     ->with('message', 'Data updated successfully');
}




  public function destroy($id)
{
    $traineesdetail = TraineesDetail::findOrFail($id);

    $traineesdetail->update([
        'deleted_by' => Auth::id(),
    ]);

    $traineesdetail->delete();   // ✅ FIXED HERE

    return redirect()->back()->with('message', 'Data deleted successfully');
}


}