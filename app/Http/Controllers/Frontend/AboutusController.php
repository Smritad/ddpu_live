<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\WhatIsDdpu;
use App\Models\StaffPersonnel;
use App\Models\OurExperience;;
use App\Models\OurMethod;;
use App\Models\SomeOfOurPastCases;
use App\Models\AboutusTestimonials;



class AboutusController extends Controller
{

public function index()
{
    $ddpu = WhatIsDdpu::whereNull('deleted_by')
        ->latest()
        ->first();

    $galleryImages = [];

    if ($ddpu && !empty($ddpu->gallery_images)) {
        // Already an array because of $casts in model
        $galleryImages = $ddpu->gallery_images;
    }

    return view('frontend.what-is-ddpu', compact('ddpu', 'galleryImages'));
}



public function staffpersonnel()
{
    $staffBanner = StaffPersonnel::whereNull('deleted_by')
        ->latest()
        ->first();

    $staffList = StaffPersonnel::whereNull('deleted_by')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('frontend.staff-personnel', compact('staffBanner', 'staffList'));
}

public function show($slug)
{
    $staff = StaffPersonnel::where('slug', $slug)
                ->whereNull('deleted_by')
                ->firstOrFail(); // 404 if not found

    return view('frontend.staff-detail', compact('staff'));
}


public function ourexperience()
{
    $ourexperience = OurExperience::whereNull('deleted_by')
        ->latest()
        ->first();

    
    return view('frontend.our-experience', compact('ourexperience'));
}
public function ourmethod()
{
    $ourmethod = OurMethod::whereNull('deleted_by')
        ->latest()
        ->first();

    return view('frontend.our-method', compact('ourmethod'));
}

public function pastcases()
{
    $someofourpastcases = SomeOfOurPastCases::whereNull('deleted_by')
        ->latest()
        ->first();

    return view('frontend.past-cases', compact('someofourpastcases'));
}

public function testimonials()
{
    $testimonials = AboutusTestimonials::whereNull('deleted_by')
        ->latest()
        ->first();

    $items = [];

    if ($testimonials && $testimonials->items) {
        $items = json_decode($testimonials->items, true);
    }

    return view('frontend.testimonials', compact('testimonials', 'items'));
}


}