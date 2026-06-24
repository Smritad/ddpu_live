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
use App\Models\SasDoctorsNonTrainingDetails;


class SasDoctorsNonTrainingGradesController extends Controller
{

 public function index()
{
    $sasdoctorsnontraining = SasDoctorsNonTrainingDetails::latest()->get();

    // Pass data to the index view
    return view('backend.services.SasDoctorsNonTrainingGrades.index', compact('sasdoctorsnontraining'));
}


     public function create(Request $request)
    { 
        return view('backend.services.SasDoctorsNonTrainingGrades.create');
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
    $request->banner_image->move(public_path('SasDoctorsNonTrainingGrades/banner'), $bannerName);

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
    SasDoctorsNonTrainingDetails::create([
        'banner_image' => $bannerName,
        'heading'      => $request->heading,
        'details'      => $details,
        'created_by'   => auth()->id(),
    ]);

    return redirect()->route('sas-doctors-grades-details.index')
                     ->with('message', 'Data saved successfully');
}




   /* ==========================
        EDIT
    ========================== */
  public function edit($id)
{
    $sasdoctorsnontraining = SasDoctorsNonTrainingDetails::findOrFail($id);

    return view('backend.services.SasDoctorsNonTrainingGrades.edit', compact('sasdoctorsnontraining'));
}

public function update(Request $request, $id)
{
    $sasdoctorsnontraining = SasDoctorsNonTrainingDetails::findOrFail($id);

    $request->validate([
        'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp|max:10240',
        'heading'      => 'required|string|max:255',
        'title.*'      => 'required|string|max:255',
        'description.*'=> 'nullable|string',
    ]);

    // Upload Banner if new
    if ($request->hasFile('banner_image')) {
        if ($sasdoctorsnontraining->banner_image && file_exists(public_path('SasDoctorsNonTrainingGrades/banner/'.$sasdoctorsnontraining->banner_image))) {
            unlink(public_path('SasDoctorsNonTrainingGrades/banner/'.$sasdoctorsnontraining->banner_image));
        }
        $bannerName = time().'_banner.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('SasDoctorsNonTrainingGrades/banner'), $bannerName);
    } else {
        $bannerName = $sasdoctorsnontraining->banner_image;
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
    $sasdoctorsnontraining->update([
        'banner_image' => $bannerName,
        'heading'      => $request->heading,
        'details'      => $details,
        'updated_by'   => auth()->id(),
    ]);

    return redirect()->route('sas-doctors-grades-details.index')
                     ->with('message', 'Data updated successfully');
}




  public function destroy($id)
{
    $sasdoctorsnontraining = SasDoctorsNonTrainingDetails::findOrFail($id);

    $sasdoctorsnontraining->update([
        'deleted_by' => Auth::id(),
    ]);

    $sasdoctorsnontraining->delete();   // ✅ FIXED HERE

    return redirect()->back()->with('message', 'Data deleted successfully');
}


}