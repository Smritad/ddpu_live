<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Signupform;
use App\Models\MembershipApplicationform;
 use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
class SignupController extends Controller
{
     public function index($id)
{
    return view('frontend.signup', compact('id'));
}



    // STEP 1 SAVE
    public function saveStep1(Request $request)
    {
        $record = MembershipApplicationform::where('user_id', $request->user_id)->first();

        if (!$record) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $stepData = $request->step1_data;

        // PHYSICAL FILE UPLOAD
        if ($request->hasFile('mandate_file')) {

            $file = $request->file('mandate_file');
            $fileName = 'direct_debit_' . time() . '.' . $file->getClientOriginalExtension();

            $path = public_path('direct-debit');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file->move($path, $fileName);
            $stepData['file_name'] = $fileName;
        }

        $record->step1_signup = $stepData;
        $record->final_submit_signup = 0;
        $record->save();

        return response()->json(['success' => true]);
    }

    // // FINAL SUBMIT
    // public function finalSubmit(Request $request)
    // {
    //     $record = MembershipApplicationform::where('user_id', $request->user_id)->first();

    //     if (!$record || !$record->step1_signup) {
    //         return response()->json(['error' => 'Step 1 not completed'], 422);
    //     }

    //     $record->final_submit_signup = 1;
    //     $record->submitted_at = now();
    //     $record->save();

    //     return response()->json(['success' => true]);
    // }


 

public function finalSubmit(Request $request)
{
    $record = MembershipApplicationform::where('user_id', $request->user_id)->first();

    if (!$record || !$record->step1_signup) {
        return response()->json(['error' => 'Step 1 not completed'], 422);
    }

    /* ================= GENERATE DD REFERENCE ================= */
    DB::beginTransaction();

    try {
        // Lock row to avoid duplicate DD reference
        $lastRef = MembershipApplicationform::whereNotNull('dd_reference')
            ->orderBy('id', 'desc')
            ->lockForUpdate()
            ->value('dd_reference');

        $lastNumber = 0;
        if ($lastRef && preg_match('/DDPU-(\d+)/', $lastRef, $matches)) {
            $lastNumber = (int) $matches[1];
        }

        $nextNumber = $lastNumber + 1;
        $ddReference = 'DDPU-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        // Save final submit data
        $record->final_submit_signup = 1;
        $record->submitted_at = now();
        $record->dd_reference = $ddReference;
        $record->save();

        DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Unable to generate DD Reference'], 500);
    }

    /* ================= DECODE DATA ================= */
    $step1 = is_array($record->step1_signup)
        ? $record->step1_signup
        : json_decode($record->step1_signup, true);

    $step2 = is_array($record->step2)
        ? $record->step2
        : json_decode($record->step2, true);

    $userEmail = $step2['primary_email'] ?? null;
    $userName  = $step2['full_name'] ?? 'User';

    /* ================= PDF ================= */
    $pdf = Pdf::loadView('pdf.direct-debit', [
        'type'           => $step1['type'],
        'accountHolder' => $step1['account_holder'] ?? null,
        'accountNumber' => $step1['account_number'] ?? null,
        'sortCode'      => $step1['sort_code'] ?? null,
        'bankName'      => $step1['bank_name'] ?? null,
        'branchName'    => $step1['branch_name'] ?? null,
        'companyName'   => $step1['company_name'] ?? null,
        'serviceNumber' => $step1['service_number'],
        'ddReference'   => $ddReference,
        'date'          => now()->format('d F, Y'),
    ]);

    $pdfFileName = 'Direct_Debit_' . $ddReference . '.pdf';

    /* ================= EMAIL ================= */
    if ($userEmail) {
        Mail::send('emails.direct-debit', [
            'name'           => $userName,
            'type'           => $step1['type'],
            'serviceNumber' => $step1['service_number'],
            'ddReference'   => $ddReference,
            'companyName'   => $step1['company_name'] ?? null,
            'mandateUrl'    => isset($step1['mandate_file'])
                                ? asset('storage/' . $step1['mandate_file'])
                                : null,
        ], function ($message) use ($userEmail, $pdf, $pdfFileName) {
            $message->to($userEmail)
                ->subject('Direct Debit Instruction - DDPU')
                ->attachData($pdf->output(), $pdfFileName);
        });
    }

    return response()->json([
        'success'      => true,
        'dd_reference' => $ddReference
    ]);
}


public function generatePdf($userId)
{
    
    $record = MembershipApplicationform::find($userId);

    if (!$record || !$record->step1_signup) {
        abort(404, "Application data not found.");
    }

    // Decode JSON if step1_data is stored as JSON
    $data = is_array($record->step1_signup) ? $record->step1_signup : json_decode($record->step1_signup, true);
    if (!$data) {
        abort(404, "Step1 data is empty or invalid.");
    }

    $serviceNumber = $data['service_number'] ?? 'UNKNOWN';

    $pdf = Pdf::loadView('pdf.direct-debit', [
        'accountHolder' => $data['account_holder'] ?? null,
        'accountNumber' => $data['account_number'] ?? null,
        'sortCode'      => $data['sort_code'] ?? null,
        'bankName'      => $data['bank_name'] ?? null,
        'branchName'    => $data['branch_name'] ?? null,
        'companyName'   => $data['company_name'] ?? null,
        'serviceNumber' => $serviceNumber,
        'date'          => now()->format('d F, Y')
    ]);

$safeServiceNumber = str_replace(['/', '\\'], '_', $serviceNumber);
return $pdf->download("Direct_Debit_Instruction_{$safeServiceNumber}.pdf");
}

}
