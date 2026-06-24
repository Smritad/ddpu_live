<?php
namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\FooterDetails;

class FooterDetailsController extends Controller
{
   public function index()
{
    $records = FooterDetails::latest()->get();
    return view('backend.home-page.footer-details.index', compact('records'));
}

public function create()
{
    return view('backend.home-page.footer-details.create');
}

public function store(Request $request)
{
    $request->validate([
        'logo' => 'required|image',
        'description' => 'required|string',
        'address' => 'required|string',
        'email' => 'required|email',
        'map_url' => 'required|string',
        'phone' => 'required|string',
        'social_title' => 'array|min:1',
        'social_title.*' => 'string',
        'social_link' => 'array|min:1',
        'social_link.*' => 'url',
    ]);

    $logoName = null;
    if ($request->hasFile('logo')) {
        $logo = $request->file('logo');
        $logoName = time().'_'.$logo->getClientOriginalName();
        $logo->move(public_path('uploads/footer'), $logoName);
    }

    FooterDetails::create([
        'logo' => $logoName,
        'description' => $request->description,
        'address' => $request->address,
'mapurl' => $request->map_url,
        'email' => $request->email,
        'phone' => $request->phone,
        'social_titles' => implode(',', $request->social_title),
        'social_links' => implode(',', $request->social_link),
        'created_by' => auth()->id(),
    ]);

    return redirect()->route('footer-details.index')->with('message', 'Footer Details added successfully!');
}

public function edit($id)
{
    $record = FooterDetails::findOrFail($id);
    $social_titles = explode(',', $record->social_titles);
    $social_links = explode(',', $record->social_links);
    return view('backend.home-page.footer-details.edit', compact('record', 'social_titles', 'social_links'));
}

public function update(Request $request, $id)
{
    $record = FooterDetails::findOrFail($id);

    $logoName = $record->logo;
    if ($request->hasFile('logo')) {
        $logo = $request->file('logo');
        $logoName = time().'_'.$logo->getClientOriginalName();
        $logo->move(public_path('uploads/footer'), $logoName);
    }

    $record->update([
        'logo' => $logoName,
        'description' => $request->description,
        'address' => $request->address,
        'email' => $request->email,
               'mapurl' => $request->map_url,
        'phone' => $request->phone,
        'social_titles' => implode(',', $request->social_title),
        'social_links' => implode(',', $request->social_link),
        'updated_by' => auth()->id(),
    ]);

    return redirect()->route('footer-details.index')->with('message', 'Footer Details updated successfully!');
}

public function destroy($id)
{
    $record = FooterDetails::findOrFail($id);
    $record->update(['deleted_by' => auth()->id()]);
    $record->delete();

    return redirect()->route('footer-details.index')->with('message', 'Footer deleted successfully!');
}



}
