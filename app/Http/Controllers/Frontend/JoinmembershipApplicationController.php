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
use App\Models\UsersMembership;
use Illuminate\Support\Facades\Log;


class JoinmembershipApplicationController extends Controller
{

  public function index()
{

    // Fetch all countries from main_countries table
    $countries = DB::table('main_countries')->orderBy('name')->get();

    $joinmembership = JoinMembershipDetail::whereNull('deleted_at')->first();
    return view('frontend.joinmembership',compact('joinmembership','countries'));


}





// public function saveStep(Request $request)
// {
    
//     $step = $request->step;

//     // Get draft or create new
//     $application = MembershipApplicationform::where('final_status', 0)
//     ->where('session_id', session()->getId())
//     ->first();    if (!$application) {
//         $application = MembershipApplicationform::create([
//             'final_status' => 0,
//             'session_id' => session()->getId(),
//             'ip_address' => $request->ip(),
//         ]);
//     }

//     $data = [];

//     foreach ($request->data ?? [] as $key => $value) {
//         if ($value instanceof \Illuminate\Http\UploadedFile) {

//             $fileName = time() . '_' . $value->getClientOriginalName();
//             $value->move(public_path('applications'), $fileName);

//             $data[$key] = 'applications/' . $fileName;
//         } else {
//             $data[$key] = $value;
//         }
//     }

//     $column = "step" . $step;
//     $application->$column = $data;
//     $application->save();

//     return response()->json(['status' => 'success', 'message' => "Step $step saved"]);
// }
public function saveStep(Request $request)
{
    $step = $request->step;

    // Get draft or create new
    $application = MembershipApplicationform::where('final_status', 0)
        ->where('session_id', session()->getId())
        ->first();

    if (!$application) {
        $application = MembershipApplicationform::create([
            'final_status' => 0,
            'session_id' => session()->getId(),
            'ip_address' => $request->ip(),
        ]);
    }

    $data = [];

    foreach ($request->data ?? [] as $key => $value) {

        // ===============================
        // FILE UPLOAD HANDLING
        // ===============================
        if ($value instanceof \Illuminate\Http\UploadedFile) {

            $fileName = time() . '_' . $value->getClientOriginalName();

            // ðŸ”¥ STEP 7 FILE â†’ designated_body_docu
            if ($step == 7) {
                $value->move(public_path('designated_body_docu'), $fileName);
                $data[$key] = 'designated_body_docu/' . $fileName;
            } else {
                // other steps normal upload folder
                $value->move(public_path('applications'), $fileName);
                $data[$key] = 'applications/' . $fileName;
            }

        } else {
            $data[$key] = $value;
        }
    }

    // Save JSON in column step1, step2 ... step7
    $column = "step" . $step;
    $application->$column = $data;
    $application->save();

    return response()->json([
        'status' => 'success',
        'message' => "Step $step saved successfully"
    ]);
}


/**
 * Final submit
 */

public function submitApplication(Request $request)
{
    Log::info('submitApplication called', [
        'session_id' => session()->getId(),
        'ip' => $request->ip(),
        'request_data' => $request->all()
    ]);

    $application = MembershipApplicationform::where('final_status', 0)
        ->where('session_id', session()->getId())
        ->first();

    if (!$application) {
        Log::error('No draft application found');
        return response()->json([
            'status' => 'error',
            'message' => 'No draft found'
        ], 404);
    }

    Log::info('Draft application found', ['application_id' => $application->id]);

    try {
        $step1 = $application->step1 ?? [];
        $step2 = $application->step2 ?? [];

        // Build full name
        $firstName  = $step1['first_name'] ?? '';
        $middleName = $step1['middle_name'] ?? '';
        $lastName   = $step1['last_name'] ?? '';

        $name = trim($firstName . ' ' . $middleName . ' ' . $lastName);

        // Email & phone
        $email = $step2['primary_email'] ?? null;
        $phone = $step2['mobile_number'] ?? null;

        if (!$email) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email is required in step 2'
            ], 400);
        }

        // ✅ Allow duplicate email (no check)

        $user = \App\Models\UsersMembership::create([
            'name'     => $name,
            'email'    => $email,
            'phone'    => $phone,
            'password' => bcrypt('123456'),
        ]);

        Log::info('User created', ['user_id' => $user->id]);

        $application->update([
            'final_status' => 1,
            'submitted_at' => now(),
            'user_id'      => $user->id,
            'session_id'   => null,
            'ip_address'   => $request->ip(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Application submitted successfully',
            'application_id' => $application->id,
            'user_id' => $user->id,
        ]);

    } catch (\Throwable $e) {
        Log::error('submitApplication error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Server error, check logs'
        ], 500);
    }
}

/**
 * Load all saved data
 */
public function getSavedApplication()
{
    $application = MembershipApplicationform::latest('id')->first();

    return response()->json(['status'=>'success','data'=>$application]);
}



public function getLastStep(Request $request)
{
    $sessionId = session()->getId();

    Log::info('getLastStep called', [
        'session_id' => $sessionId,
        'ip' => $request->ip()
    ]);

    $app = MembershipApplicationForm::where('session_id', $sessionId)->latest()->first();

    if (!$app) {
        return response()->json(['step' => 1]);
    }

    $step = 1;

    if ($app->step1) $step = 2;
    if ($app->step2) $step = 3;
    if ($app->step3) $step = 4;
    if ($app->step4) $step = 5;
    if ($app->step5) $step = 6;
    if ($app->step6) $step = 7;
        if ($app->step7) $step = 8;


    return response()->json([
        'step' => $step,
        'data' => $app
    ]);
}

}

