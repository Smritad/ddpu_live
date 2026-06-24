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
use App\Models\AboutusTestimonials;


class AboutusTestimonialsDetailsController extends Controller
{

         public function index()
        {
             $aboutustestimonials = AboutusTestimonials::orderBy('created_at','desc')->get();
            return view('backend.about-page.aboutus-testimonials-details.index', compact('aboutustestimonials'));
        }

    
         public function create(Request $request)
        { 
            return view('backend.about-page.aboutus-testimonials-details.create');
        }


       public function store(Request $request)
        {
            $request->validate([
                'banner_image' => 'required|image',
                'items.*.name' => 'required',
                'items.*.profession' => 'required',
                'items.*.description' => 'required',
                'items.*.image' => 'required|image',
            ]);
        
            /* Upload banner */
            $bannerName = time().'_banner.'.$request->banner_image->extension();
            $request->banner_image->move(public_path('uploads/aboutustestimonials'), $bannerName);
        
            $itemsData = [];
        
            foreach ($request->items as $key => $item) {
                $imgName = time().'_'.$key.'.'.$item['image']->extension();
                $item['image']->move(public_path('uploads/aboutustestimonials/'), $imgName);
        
                $itemsData[] = [
                    'image' => $imgName,
                    'name' => $item['name'],
                    'profession' => $item['profession'],
                    'description' => $item['description'],
                ];
            }
        
            AboutusTestimonials::create([
                'banner_image' => $bannerName,
                'items' => json_encode($itemsData),
                'created_by' => auth()->id()
            ]);
        
            return redirect()->back()->with('message','Saved successfully');
        }





    // ==========================
        // EDIT
        // ==========================
    public function edit($id)
    {
    $testimonial = AboutusTestimonials::findOrFail($id);

    $items = json_decode($testimonial->items, true);

    return view('backend.about-page.aboutus-testimonials-details.edit', compact('testimonial','items'));
}

    // ==========================
    // UPDATE
    // ==========================
   public function update(Request $request, $id)
{
    $testimonial = AboutusTestimonials::findOrFail($id);

    $request->validate([
        'items.*.name' => 'required',
        'items.*.profession' => 'required',
        'items.*.description' => 'required',
        'items.*.image' => 'nullable|image',
        'banner_image' => 'nullable|image'
    ]);

    /* =======================
        Banner Update
    ======================= */
    $bannerName = $testimonial->banner_image;

    if ($request->hasFile('banner_image')) {
        if ($bannerName && file_exists(public_path('uploads/aboutustestimonials/'.$bannerName))) {
            unlink(public_path('uploads/aboutustestimonials/'.$bannerName));
        }

        $bannerFile = $request->file('banner_image');
        $bannerName = time().'_banner.'.$bannerFile->extension();
        $bannerFile->move(public_path('uploads/aboutustestimonials'), $bannerName);
    }

    /* =======================
        Items Update
    ======================= */
    $itemsData = [];

    foreach ($request->items as $key => $item) {

        if (!empty($item['image'])) {
            $imgName = time().'_'.$key.'.'.$item['image']->extension();
            $item['image']->move(public_path('uploads/aboutustestimonials'), $imgName);
        } else {
            $imgName = $item['old_image']; // keep old image
        }

        $itemsData[] = [
            'image' => $imgName,
            'name' => $item['name'],
            'profession' => $item['profession'],
            'description' => $item['description'],
        ];
    }

    $testimonial->update([
        'banner_image' => $bannerName,
        'items' => json_encode($itemsData),
        'updated_by' => auth()->id()
    ]);

    return redirect()->route('aboutus-testimonials-details.index')
        ->with('message','Updated successfully');
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