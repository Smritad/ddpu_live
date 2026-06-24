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
use App\Models\SomeOfOurPastCases;


class SomeOfOurPastCasesDetailsController extends Controller
{

         public function index()
{
$cases = SomeOfOurPastCases::orderBy('created_at','desc')->get();
    return view('backend.about-page.some-of-our-past-cases.index', compact('cases'));
}

    
     public function create(Request $request)
    { 
        return view('backend.about-page.some-of-our-past-cases.create');
    }


public function store(Request $request)
{
    // ✅ Validation
    $request->validate([
        'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'description' => 'required|string',
        'heading' => 'required|string',

        // new structure validation
        'titles.*.title' => 'required|string|max:255',
        'titles.*.link'  => 'nullable|url|max:500',
    ]);

    // ✅ Upload Banner Image
    $bannerName = null;

    if ($request->hasFile('banner_image')) {
        $bannerFile = $request->file('banner_image');
        $bannerName = time().'_banner.'.$bannerFile->getClientOriginalExtension();
        $bannerFile->move(public_path('uploads/past-cases'), $bannerName);
    }

    // ✅ Prepare Titles
    $titles = $request->input('titles', []);

    // remove empty rows
    $titles = array_values(array_filter($titles, function ($row) {
        return !empty($row['title']);
    }));

    $titlesJson = json_encode($titles);

    // ✅ Save
    SomeOfOurPastCases::create([
        'banner_image' => $bannerName,
        'description'  => $request->description,
        'heading'      => $request->heading,
        'titles'       => $titlesJson,
        'created_by'   => auth()->id(),
    ]);

    return redirect()
        ->route('some-of-our-past-cases.index')
        ->with('message', 'Past Case added successfully!');
}





// ==========================
    // EDIT
    // ==========================
    public function edit($id)
{
    $case = SomeOfOurPastCases::findOrFail($id);

    // Decode JSON safely
    $titles = json_decode($case->titles, true) ?? [];

    // Normalize structure (important if old data exists)
    $titles = array_map(function ($item) {

        // If old data was stored as string
        if (is_string($item)) {
            return [
                'title' => $item,
                'link'  => ''
            ];
        }

        // If already new format
        return [
            'title' => $item['title'] ?? '',
            'link'  => $item['link'] ?? ''
        ];

    }, $titles);

    return view(
        'backend.about-page.some-of-our-past-cases.edit',
        compact('case', 'titles')
    );
}

    // ==========================
    // UPDATE
    // ==========================
   public function update(Request $request, $id)
{
    $case = SomeOfOurPastCases::findOrFail($id);

    // ✅ Validation
    $request->validate([
        'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:10240',
        'description' => 'required|string',
        'heading' => 'required|string',

        // each row validation
        'titles.*.title' => 'required|string|max:255',
        'titles.*.link'  => 'nullable|url|max:500',
    ]);

    // ✅ Upload Banner Image
    $bannerName = $case->banner_image;

    if ($request->hasFile('banner_image')) {

        if ($bannerName && file_exists(public_path('uploads/past-cases/'.$bannerName))) {
            unlink(public_path('uploads/past-cases/'.$bannerName));
        }

        $bannerFile = $request->file('banner_image');
        $bannerName = time().'_banner.'.$bannerFile->getClientOriginalExtension();
        $bannerFile->move(public_path('uploads/past-cases'), $bannerName);
    }

    // ✅ Prepare Titles Array
    $titles = $request->input('titles', []);

    // remove empty rows automatically
    $titles = array_values(array_filter($titles, function ($row) {
        return !empty($row['title']);
    }));

    // encode to JSON
    $titlesJson = json_encode($titles);

    // ✅ Update DB
    $case->update([
        'banner_image' => $bannerName,
        'description'  => $request->description,
        'heading'      => $request->heading,
        'titles'       => $titlesJson,
        'updated_by'   => auth()->id(),
    ]);

    return redirect()
        ->route('some-of-our-past-cases.index')
        ->with('message', 'Past Case updated successfully!');
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