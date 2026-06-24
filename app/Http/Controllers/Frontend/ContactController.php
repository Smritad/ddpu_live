<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\FooterDetails;




class ContactController extends Controller
{

public function index()
{
    $contact = FooterDetails::latest()->first();   // ✅ use first() not get()
    return view('frontend.contactus', compact('contact'));
}




public function send(Request $request)
{
    // ✅ Validate the form
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'nullable|string',
    ]);

    // ✅ Collect form data
    $details = [
        'name'    => $request->name,
        'email'   => $request->email,
        'subject' => $request->subject ?? '',
        'message' => $request->message,
    ];

    // ✅ Send mail to admin
    try {
        Mail::send('emails.contact_admin', ['details' => $details], function ($message) use ($details) {
            $message->to('smrita@matrixbricks.com')
                    ->cc(['smrita@matrixbricks.com', 'smrita@matrixbricks.com'])
                    ->subject('Contact Us Enquiry');
        });
    } catch (\Exception $e) {
        Log::error('Failed to send contact mail to admin: ' . $e->getMessage());
    }

   try {
    Mail::send('emails.contact_user', ['details' => $details], function ($message) use ($details) {
        $message->to($details['email'])
                ->subject('Thank You for Your Enquiry');
    });
    Log::info('User mail sent to: ' . $details['email']);
} catch (\Exception $e) {
    Log::error('Failed to send thank-you mail to user: ' . $e->getMessage());
}


    // ✅ Redirect to thank-you page
    return redirect()->route('thankyou')->with('success', 'Your enquiry has been sent successfully.');
}

}