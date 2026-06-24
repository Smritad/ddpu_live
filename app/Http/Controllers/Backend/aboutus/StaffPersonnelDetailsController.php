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
use App\Models\StaffPersonnel;


class StaffPersonnelDetailsController extends Controller
{

public function show($slug)
    {
        $staff = StaffPersonnel::where('slug', $slug)
                    ->whereNull('deleted_by')
                    ->firstOrFail();

        return view('frontend.staff-detail', compact('staff'));
    }

           public function index()
        {
            $staffPersonnel = StaffPersonnel::latest()->get();
        
            return view('backend.about-page.staff-personnel.index', compact('staffPersonnel'));
        }

    
     public function create(Request $request)
    { 
        return view('backend.about-page.staff-personnel.create');
    }




 /* ========================
        STORE
    ========================= */
public function store(Request $request)
{
    $validatedData = $request->validate([
        'banner_image'   => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'profile_image'  => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:5120',
        'name'           => 'required|string|max:255',
        'designation'    => 'required|string|max:255',
        'title'          => 'nullable|string|max:255',
        'description'    => 'nullable|string',
        'social_name.*'  => 'nullable|string|max:255',
        'social_link.*'  => 'nullable|url|max:255',
    ]);

    // Handle Banner Image
    if ($request->hasFile('banner_image')) {
        $bannerImage = $request->file('banner_image');
        $bannerImageName = time().'_banner.'.$bannerImage->getClientOriginalExtension();
        $bannerImage->move(public_path('uploads/staff-personnel'), $bannerImageName);
        $validatedData['banner_image'] = $bannerImageName;
    }

    // Handle Profile Image
    if ($request->hasFile('profile_image')) {
        $profileImage = $request->file('profile_image');
        $profileImageName = time().'_profile.'.$profileImage->getClientOriginalExtension();
        $profileImage->move(public_path('uploads/staff-personnel'), $profileImageName);
        $validatedData['profile_image'] = $profileImageName;
    }

    // Social Links
    $socialLinks = [];
    if ($request->filled('social_name') && $request->filled('social_link')) {
        foreach ($request->social_name as $i => $name) {
            $link = $request->social_link[$i] ?? null;
            if ($name && $link) {
                $socialLinks[] = ['name' => $name, 'link' => $link];
            }
        }
    }

    // Create record
    StaffPersonnel::create([
        'name'          => $validatedData['name'],
        'slug'          => Str::slug($validatedData['name']), // auto slug
        'designation'   => $validatedData['designation'],
        'title'         => $validatedData['title'] ?? null,
        'description'   => $validatedData['description'] ?? null,
        'banner_image'  => $validatedData['banner_image'] ?? null,
        'profile_image' => $validatedData['profile_image'] ?? null,
        'social_links'  => $socialLinks, // store as array, let model cast handle JSON
        'created_by'    => Auth::id(),
    ]);

    return redirect()->route('staff-personnel.index')->with('message', 'Staff personnel added successfully.');
}


 /* ==========================
        EDIT
    ========================== */
public function edit($id)
{
    $staff = StaffPersonnel::findOrFail($id);

    // Ensure social_links is always array
    $socialLinks = [];
    if (!empty($staff->social_links)) {
        if (is_string($staff->social_links)) {
            $socialLinks = json_decode($staff->social_links, true) ?? [];
        } elseif (is_array($staff->social_links)) {
            $socialLinks = $staff->social_links;
        }
    }

    return view('backend.about-page.staff-personnel.edit', compact('staff', 'socialLinks'));
}


 /* ==========================
        UPDATE
    ========================== */
public function update(Request $request, $id)
{
    $staff = StaffPersonnel::findOrFail($id);

    $validatedData = $request->validate([
        'banner_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'profile_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:5120',
        'name'           => 'required|string|max:255',
        'designation'    => 'required|string|max:255',
        'title'          => 'nullable|string|max:255',
        'description'    => 'nullable|string',
        'social_name.*'  => 'nullable|string|max:255',
        'social_link.*'  => 'nullable|url|max:255',
    ]);

    // Banner Image
    if ($request->hasFile('banner_image')) {
        $bannerImage = $request->file('banner_image');
        $bannerImageName = time().'_banner.'.$bannerImage->getClientOriginalExtension();
        $bannerImage->move(public_path('uploads/staff-personnel'), $bannerImageName);

        if ($staff->banner_image && file_exists(public_path('uploads/staff-personnel/'.$staff->banner_image))) {
            unlink(public_path('uploads/staff-personnel/'.$staff->banner_image));
        }

        $validatedData['banner_image'] = $bannerImageName;
    } else {
        $validatedData['banner_image'] = $staff->banner_image;
    }

    // Profile Image
    if ($request->hasFile('profile_image')) {
        $profileImage = $request->file('profile_image');
        $profileImageName = time().'_profile.'.$profileImage->getClientOriginalExtension();
        $profileImage->move(public_path('uploads/staff-personnel'), $profileImageName);

        if ($staff->profile_image && file_exists(public_path('uploads/staff-personnel/'.$staff->profile_image))) {
            unlink(public_path('uploads/staff-personnel/'.$staff->profile_image));
        }

        $validatedData['profile_image'] = $profileImageName;
    } else {
        $validatedData['profile_image'] = $staff->profile_image;
    }

    // Social Links
    $socialLinks = [];
    if ($request->filled('social_name') && $request->filled('social_link')) {
        foreach ($request->social_name as $i => $name) {
            $link = $request->social_link[$i] ?? null;
            if ($name && $link) {
                $socialLinks[] = ['name' => $name, 'link' => $link];
            }
        }
    }

    $staff->update([
        'name'          => $validatedData['name'],
        'slug'          => Str::slug($validatedData['name']),
        'designation'   => $validatedData['designation'],
        'title'         => $validatedData['title'] ?? null,
        'description'   => $validatedData['description'] ?? null,
        'banner_image'  => $validatedData['banner_image'],
        'profile_image' => $validatedData['profile_image'],
        'social_links'  => $socialLinks,
        'updated_by'    => Auth::id(),
    ]);

    return redirect()->route('staff-personnel.index')->with('message', 'Staff personnel updated successfully.');
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