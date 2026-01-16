<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\MembershipApplicationform;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;

class CustomerPhysicalDetailsController extends Controller
{
 public function index()
{
    $memberships = MembershipApplicationform::whereJsonContains('step1_signup->type', 'physical')
        ->orderByDesc('id')
        ->get();

    return view('backend.customer-physical-details.index', compact('memberships'));
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


public function export($type)
{
    // Only 'physical' type records
    $memberships = MembershipApplicationform::whereJsonContains('step1_signup->type', 'physical')
        ->orderByDesc('id')
        ->get();

    if ($type === 'csv') {
        return new StreamedResponse(function () use ($memberships) {
            $handle = fopen('php://output', 'w');

            /* ================= HEADER ================= */
            fputcsv($handle, [
                'DD Reference',
                'Payment Plan',
                'Direct Debit Form URL',
                'Date',
                'Status'
            ]);

            foreach ($memberships as $member) {
                $step1 = is_array($member->step1_signup)
                    ? $member->step1_signup
                    : json_decode($member->step1_signup, true);

                /* FILE URL */
                $fileUrl = !empty($step1['file_name'])
                    ? asset('direct-debit/' . $step1['file_name'])
                    : '';

                fputcsv($handle, [
                    $member->dd_reference ?? '', // ✅ FIXED
                    $step1['payment_plan'] ?? '',
                    $fileUrl,
                    optional($member->submitted_at)->format('d-m-Y')
                        ?? optional($member->created_at)->format('d-m-Y'),
                    $member->status ?? '',
                ]);
            }

            fclose($handle);

        }, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition'=> 'attachment; filename="customer-physical.csv"',
        ]);
    }

    /* ================= EXCEL EXPORT ================= */
    return Excel::download(
        new \App\Exports\CustomerPhysicalExport($memberships),
        'customer-physical.xlsx'
    );
}


}