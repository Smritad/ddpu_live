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
use App\Models\OurMethod;;


class OurmethodDetailsController extends Controller
{

         public function index()
{
    // Fetch all OurMethod records
    $ourMethods = \App\Models\OurMethod::orderBy('id', 'desc')->get();

    return view('backend.about-page.our-method.index', compact('ourMethods'));
}

    
     public function create(Request $request)
    { 
        return view('backend.about-page.our-method.create');
    }


public function store(Request $request)
{
    // Validation
    $request->validate([
        'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'strategic_title' => 'required|string|max:255',
        'strategic_elements_title' => 'required|string|max:255',
        'strategic_image' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'strategic_description' => 'nullable|string',
        'elements.*.icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'elements.*.title' => 'nullable|string|max:255',
        'elements.*.description' => 'nullable|string',
    ]);

    // Upload Banner
    if($request->hasFile('banner_image')){
        $bannerName = time().'_banner.'.$request->banner_image->getClientOriginalExtension();
        $request->banner_image->move(public_path('uploads/our-method'), $bannerName);
    }

    // Upload Strategic Image
    if($request->hasFile('strategic_image')){
        $strategicName = time().'_strategic.'.$request->strategic_image->getClientOriginalExtension();
        $request->strategic_image->move(public_path('uploads/our-method'), $strategicName);
    }

    // Upload Elements Icons
    $elements = [];
    if($request->has('elements')){
        foreach($request->elements as $key => $element){
            $iconName = null;
            if(isset($element['icon'])){
                $iconFile = $element['icon'];
                $iconName = time().'_icon_'.$key.'.'.$iconFile->getClientOriginalExtension();
                $iconFile->move(public_path('uploads/our-method/elements'), $iconName);
            }
            $elements[] = [
                'icon' => $iconName,
                'title' => $element['title'] ?? null,
                'description' => $element['description'] ?? null
            ];
        }
    }

    // Store in DB
    OurMethod::create([
        'banner_image' => $bannerName ?? null,
        'strategic_title' => $request->strategic_title,
        'strategic_elements_title' => $request->strategic_elements_title,
        'strategic_image' => $strategicName ?? null,
        'strategic_description' => $request->strategic_description,
        'elements' => json_encode($elements),
        'created_by' => Auth::id(),
    ]);

    return redirect()->route('our-method.index')->with('message','Our Method added successfully!');
}




// ==========================
    // EDIT
    // ==========================
    public function edit($id)
    {
        $ourMethod = OurMethod::findOrFail($id);

        // Decode elements JSON for prefilling
        $elements = json_decode($ourMethod->elements, true) ?? [];

        return view('backend.about-page.our-method.edit', compact('ourMethod', 'elements'));
    }

    // ==========================
    // UPDATE
    // ==========================
    public function update(Request $request, $id)
    {
        $ourMethod = OurMethod::findOrFail($id);

        // Validation
        $request->validate([
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
            'strategic_title' => 'required|string|max:255',
             'strategic_elements_title' => 'required|string|max:255',
            'strategic_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
            'strategic_description' => 'nullable|string',
            'elements.*.icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
            'elements.*.title' => 'nullable|string|max:255',
            'elements.*.description' => 'nullable|string',
        ]);

        // Banner Image
        $bannerName = $ourMethod->banner_image;
        if ($request->hasFile('banner_image')) {
            $bannerName = time().'_banner.'.$request->banner_image->getClientOriginalExtension();
            $request->banner_image->move(public_path('uploads/our-method'), $bannerName);
        }

        // Strategic Image
        $strategicName = $ourMethod->strategic_image;
        if ($request->hasFile('strategic_image')) {
            $strategicName = time().'_strategic.'.$request->strategic_image->getClientOriginalExtension();
            $request->strategic_image->move(public_path('uploads/our-method'), $strategicName);
        }

        // Elements
        $elements = [];
        if($request->has('elements')){
            foreach($request->elements as $key => $element){
                $iconName = $ourMethod->elements ? ($ourMethod->elements[$key]['icon'] ?? null) : null;

                if(isset($element['icon'])){
                    $iconFile = $element['icon'];
                    $iconName = time().'_icon_'.$key.'.'.$iconFile->getClientOriginalExtension();
                    $iconFile->move(public_path('uploads/our-method/elements'), $iconName);
                }

                $elements[] = [
                    'icon' => $iconName,
                    'title' => $element['title'] ?? null,
                    'description' => $element['description'] ?? null
                ];
            }
        }

        // Update DB
        $ourMethod->update([
            'banner_image' => $bannerName,
            'strategic_title' => $request->strategic_title,
          'strategic_elements_title' => $request->strategic_elements_title,
            'strategic_image' => $strategicName,
            'strategic_description' => $request->strategic_description,
            'elements' => json_encode($elements),
                    'updated_by' => Auth::id(),

        ]);

        return redirect()->route('our-method.index')->with('message', 'Our Method updated successfully!');
    }

    /* ========================
        DELETE (Soft)
    ========================= */
    public function destroy($id)
    {
        $ddpu = OurMethod::findOrFail($id);

        $ddpu->update([
            'deleted_by' => Auth::id(),
        ]);

        $ddpu->delete();

        return redirect()->back()->with('message', 'Data deleted successfully');
    }


}