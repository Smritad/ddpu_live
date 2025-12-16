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





public function saveStep(Request $request)
{
    $step = $request->step;

    // Get draft or create new
    $application = MembershipApplicationform::where('final_status', 0)->latest('id')->first();
    if (!$application) {
        $application = MembershipApplicationform::create([
            'final_status' => 0,
            'session_id' => session()->getId(),
            'ip_address' => $request->ip(),
        ]);
    }

    $data = [];

    foreach ($request->data ?? [] as $key => $value) {
        if ($value instanceof \Illuminate\Http\UploadedFile) {

            $fileName = time() . '_' . $value->getClientOriginalName();
            $value->move(public_path('applications'), $fileName);

            $data[$key] = 'applications/' . $fileName;
        } else {
            $data[$key] = $value;
        }
    }

    $column = "step" . $step;
    $application->$column = $data;
    $application->save();

    return response()->json(['status' => 'success', 'message' => "Step $step saved"]);
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
        ->latest('id')
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

            // Build full name from Step 1
            $firstName  = $step1['first_name'] ?? '';
            $middleName = $step1['middle_name'] ?? '';
            $lastName   = $step1['last_name'] ?? '';

            $name = trim($firstName . ' ' . $middleName . ' ' . $lastName);

            // Email & phone still come from Step 2
            $email = $step2['primary_email'] ?? null;
            $phone = $step2['mobile_number'] ?? null;

            if (!$email) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email is required in step 2'
                ], 400);
            }


        // Check if email already exists
        $existingUser = \App\Models\UsersMembership::where('email', $email)->first();
        if ($existingUser) {
            Log::warning('Email already exists', ['email' => $email]);
            return response()->json([
                'status' => 'error',
                'message' => 'Email already exists. Please use a different email.'
            ], 409); // 409 Conflict
        }

        // Create new user
        $user = \App\Models\UsersMembership::create([
            'name'     => $name,
            'email'    => $email,
            'phone'    => $phone,
            'password' => bcrypt('123456'), // dummy password
        ]);

        Log::info('User created', ['user_id' => $user->id]);

        // Update application with final submit
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


}

