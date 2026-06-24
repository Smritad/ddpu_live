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
use App\Models\ConsultantsDetails;


class ConsultantsDetailsController extends Controller
{

 public function index()
{
    // Fetch all consultant records, latest first
    $consultants = ConsultantsDetails::latest()->get();

    // Pass data to the index view
    return view('backend.services.consultants.index', compact('consultants'));
}


     public function create(Request $request)
    { 
        return view('backend.services.consultants.create');
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
    $request->banner_image->move(public_path('consultants/banner'), $bannerName);

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
    ConsultantsDetails::create([
        'banner_image' => $bannerName,
        'heading'      => $request->heading,
        'details'      => $details,
        'created_by'   => auth()->id(),
    ]);

    return redirect()->route('consultants-details.index')
                     ->with('message', 'Data saved successfully');
}




   /* ==========================
        EDIT
    ========================== */
  public function edit($id)
{
    $ConsultantsDetails = ConsultantsDetails::findOrFail($id);

    return view('backend.services.consultants.edit', compact('ConsultantsDetails'));
}

public function update(Request $request, $id)
{
    $consultant = ConsultantsDetails::findOrFail($id);

    $request->validate([
        'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'heading'      => 'required|string|max:255',
        'title.*'      => 'required|string|max:255',
        'description.*'=> 'nullable|string',
    ]);

    // Upload Banner if new
    if ($request->hasFile('banner_image')) {
        if ($consultant->banner_image && file_exists(public_path('consultants/banner/'.$consultant->banner_image))) {
            unlink(public_path('consultants/banner/'.$consultant->banner_image));
        }
        $bannerName = time().'_banner.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('consultants/banner'), $bannerName);
    } else {
        $bannerName = $consultant->banner_image;
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
    $consultant->update([
        'banner_image' => $bannerName,
        'heading'      => $request->heading,
        'details'      => $details,
        'updated_by'   => auth()->id(),
    ]);

    return redirect()->route('consultants-details.index')
                     ->with('message', 'Data updated successfully');
}




    /* ========================
        DELETE (Soft)
    ========================= */
    public function destroy($id)
    {
        $generalpractice = ConsultantsDetails::findOrFail($id);

        $generalpractice->update([
            'deleted_by' => Auth::id(),
        ]);

        $generalpractice->delete();

        return redirect()->back()->with('message', 'Data deleted successfully');
    }


}