<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MembershipbenefitsDetails;
use App\Models\MembershipRatesOptionDetails;




class MembershipdeatilpageController extends Controller
{

public function membership_benefits()
{
    $membershipbenefits = MembershipbenefitsDetails::latest()->first();
    return view('frontend.membership-membership_benefits', compact('membershipbenefits'));
}


public function membership_rates()
{
    $membershiprates = MembershipRatesOptionDetails::latest()->first();
    return view('frontend.membership-membership_rates', compact('membershiprates'));
}
}