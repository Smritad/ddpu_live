<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MembershipApplicationform;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerDetailsController extends Controller
{
 public function index()
{
    $memberships = MembershipApplicationform::whereJsonContains('step1_signup->type', 'electronic')
        ->orderByDesc('id')
        ->get();

    return view('backend.customer-details.index', compact('memberships'));
}


public function updateStatus(Request $request)
{
    $request->validate([
        'id'     => 'required|exists:membership_applicationforms,id',
        'status' => 'required|in:pending,delivered,expired',
    ]);

    $membership = MembershipApplicationform::find($request->id);
    $membership->status = $request->status;
    $membership->save();

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully'
    ]);
}


// public function upload(Request $request)
// {
//     $request->validate([
//         'upload_file' => 'required|mimes:csv,xlsx'
//     ]);

//     $file = $request->file('upload_file');
//     $rows = Excel::toArray([], $file)[0];

//     foreach ($rows as $key => $row) {
//         if ($key === 0) continue; // Skip header

//         DB::table('membership_applicationforms')->insert([
//             'step1_signup' => json_encode([
//                 'service_number' => $row[0],
//                 'payment_plan'   => $row[1],
//                 'account_holder' => $row[2],
//                 'sort_code'      => $row[3],
//                 'account_number' => $row[4],
//             ]),
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);
//     }

//     return back()->with('success', 'File uploaded successfully');
// }



public function export($type, $recordType = 'electronic') // electronic | physical
{
    $memberships = MembershipApplicationform::whereJsonContains(
            'step1_signup->type',
            $recordType
        )
        ->orderByDesc('id')
        ->get();

    if ($type === 'csv') {
        return new StreamedResponse(function () use ($memberships, $recordType) {
            $handle = fopen('php://output', 'w');

            /* ================= HEADER ================= */
            fputcsv($handle, [
                'DD Reference',
                'Payment Plan',
                'Account / Company Name',
                'Sort Code',
                'Account Number',
                'Date',
                'Status'
            ]);

            /* ================= DATA ================= */
            foreach ($memberships as $member) {
                $step1 = is_array($member->step1_signup)
                    ? $member->step1_signup
                    : json_decode($member->step1_signup, true);

                fputcsv($handle, [
                    $member->dd_reference ?? '', // ✅ FIXED
                    $step1['payment_plan'] ?? '',

                    // Name based on type
                    $recordType === 'electronic'
                        ? ($step1['account_holder'] ?? '')
                        : ($step1['company_name'] ?? ''),

                    // Bank details only for electronic
                    $recordType === 'electronic'
                        ? ($step1['sort_code'] ?? '')
                        : '',

                    $recordType === 'electronic'
                        ? ($step1['account_number'] ?? '')
                        : '',

                    optional($member->submitted_at)->format('d-m-Y')
                        ?? optional($member->created_at)->format('d-m-Y'),

                    $member->status ?? '',
                ]);
            }

            fclose($handle);

        }, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition'=> 'attachment; filename="customer-' . $recordType . '.csv"',
        ]);
    }

    /* ================= EXCEL EXPORT ================= */
    return Excel::download(
        new \App\Exports\CustomerExport($memberships, $recordType),
        'customer-' . $recordType . '.xlsx'
    );
}



    public function collection()
    {
        return MembershipApplicationform::all()->map(function ($item) {
            $step1 = json_decode($item->step1_signup, true);

            return [
                'DD Reference'   => $step1['service_number'] ?? '',
                'Payment Plan'   => $step1['payment_plan'] ?? '',
                'Account Name'   => $step1['account_holder'] ?? '',
                'Sort Code'      => $step1['sort_code'] ?? '',
                'Account Number' => $step1['account_number'] ?? '',
                'Date'           => optional($item->submitted_at)->format('d-m-Y'),
            ];
        });
    }


}