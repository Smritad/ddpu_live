<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\BannerDetails;
use App\Models\AimDetail;
use App\Models\WhyChooseDetail;
use App\Models\TestimonialsDetail;
use App\Models\JoinMembershipDetail;
use App\Models\JoinApplication;
use App\Models\MembershipApplicationform;


class JoinmembershipApplicationController extends Controller
{

  public function index()
{

    // Fetch all countries from main_countries table
    $countries = DB::table('main_countries')->orderBy('name')->get();

    $joinmembership = JoinMembershipDetail::whereNull('deleted_at')->first();

    return view('frontend.joinmembership',compact('joinmembership','countries'));


}





   public function saveStep(Request $request)
{
    $step = $request->step;

    // get latest or create draft
    $application = MembershipApplicationform::where('final_status',0)->latest('id')->first();
    if(!$application) $application = MembershipApplicationform::create(['final_status'=>0]);

    $data = [];

  foreach($request->data ?? [] as $key => $value){
    if($value instanceof \Illuminate\Http\UploadedFile){

        // Store directly inside /public/applications
        $fileName = time().'_'.$value->getClientOriginalName();
        $value->move(public_path('applications'), $fileName);

        $data[$key] = 'applications/'.$fileName;
    }else{
        $data[$key] = $value;
    }
}


    $column = "step".$step;
    $application->$column = $data;
    $application->save();

    return response()->json(['status'=>'success','message'=>"Step $step saved"]);
}


/**
 * Final submit
 */
public function submitApplication(Request $request)
{
    $application = MembershipApplicationform::where('final_status',0)
        ->latest('id')
        ->first();

    if(!$application){
        return response()->json(['status'=>'error','message'=>'No draft found'],404);
    }

    $application->update([
        'final_status'=>1,
        'submitted_at'=>now(),
    ]);

    return response()->json(['status'=>'success','message'=>'Application submitted successfully']);
}


/**
 * Load all saved data
 */
public function getSavedApplication()
{
    $application = MembershipApplicationform::latest('id')->first();

    return response()->json(['status'=>'success','data'=>$application]);
}


}

