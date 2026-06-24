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
use App\Models\OurExperience;;


class OurExperienceDetailsController extends Controller
{

          public function index()
            {
                $ourExperiences = OurExperience::latest()->get();
            
                return view('backend.about-page.our-experience.index', compact('ourExperiences'));
            }

    
     public function create(Request $request)
    { 
        return view('backend.about-page.our-experience.create');
    }



    /* ========================
        STORE
    ========================= */
 
    

public function store(Request $request)
{
    // ==========================
    // Validation
    // ==========================
    $validated = $request->validate([
        'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:10240', // 10MB
        'title'        => 'required|string|max:255',
                'team_title'        => 'required|string|max:255',
        'description'  => 'nullable|string',
    ]);

    // ==========================
    // Upload Banner Image
    // ==========================
    if ($request->hasFile('banner_image')) {
        $image = $request->file('banner_image');
        $imageName = time().'_banner.'.$image->getClientOriginalExtension();
        $image->move(public_path('uploads/our-experience'), $imageName);
        $validated['banner_image'] = $imageName;
    }

    // ==========================
    // Store Data
    // ==========================
    OurExperience::create([
        'banner_image' => $validated['banner_image'],
        'title'        => $validated['title'],
        'team_title'        => $validated['team_title'],
        'description'  => $validated['description'] ?? null,
        'created_by'   => Auth::id(), // optional
    ]);

    return redirect()->route('our-experienced.index')
                     ->with('message', 'Experience added successfully.');
}




   /* ==========================
        EDIT
    ========================== */
   public function edit($id)
{
    $experience = OurExperience::findOrFail($id);

    return view('backend.about-page.our-experience.edit', compact('experience'));
}



    /* ==========================
        UPDATE
    ========================== */
   public function update(Request $request, $id)
{
    $experience = OurExperience::findOrFail($id);

    // ==========================
    // Validation
    // ==========================
    $validated = $request->validate([
        'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'title'        => 'required|string|max:255',
         'team_title'        => 'required|string|max:255',
        'description'  => 'nullable|string',
    ]);

    // ==========================
    // Upload Banner Image
    // ==========================
    if ($request->hasFile('banner_image')) {
        $image = $request->file('banner_image');
        $imageName = time().'_banner.'.$image->getClientOriginalExtension();
        $image->move(public_path('uploads/our-experience'), $imageName);

        // delete old image
        if ($experience->banner_image && file_exists(public_path('uploads/our-experience/'.$experience->banner_image))) {
            unlink(public_path('uploads/our-experience/'.$experience->banner_image));
        }

        $validated['banner_image'] = $imageName;
    } else {
        $validated['banner_image'] = $experience->banner_image;
    }

    // ==========================
    // Update Data
    // ==========================
    $experience->update([
        'banner_image' => $validated['banner_image'],
        'title'        => $validated['title'],
                'team_title'        => $validated['team_title'],

        'description'  => $validated['description'] ?? null,
        'updated_by'   => Auth::id(),
    ]);

    return redirect()->route('our-experienced.index')
                     ->with('message', 'Experience updated successfully.');
}



    /* ========================
        DELETE (Soft)
    ========================= */
    public function destroy($id)
    {
        $ddpu = StaffPersonnel::findOrFail($id);

        $ddpu->update([
            'deleted_by' => Auth::id(),
        ]);

        $ddpu->delete();

        return redirect()->back()->with('message', 'Data deleted successfully');
    }


}