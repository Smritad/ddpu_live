<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MembershipDetail;
use App\Models\DentistsDetails;
use App\Models\GeneralPracticeDetails;
use App\Models\ConsultantsDetails;
use App\Models\SasDoctorsNonTrainingDetails;
use App\Models\TraineesDetail;
use App\Models\ForNonMembershipDetails;
use App\Models\TrustGradeDetails;
use App\Models\PrivateSectorDetails;
use App\Models\CompareUsDetails;



class ServicesController extends Controller
{

public function membership()
{
    $membership = MembershipDetail::latest()->first();
    return view('frontend.service-membership', compact('membership'));
}

public function dentists()
{
    $dentist = DentistsDetails::latest()->first();
    return view('frontend.service-dentists', compact('dentist'));
}


public function general_practice()
{
    $generalpractice = GeneralPracticeDetails::latest()->first();
    return view('frontend.service-general-practice', compact('generalpractice'));
}

public function consultants()
{
    $consultant = ConsultantsDetails::latest()->first();
    return view('frontend.service-consultants', compact('consultant'));
}

public function sas_doctors()
{
    $sasdoctors = SasDoctorsNonTrainingDetails::latest()->first();
    return view('frontend.service-sasdoctors', compact('sasdoctors'));
}

public function trainees()
{
    $trainees = TraineesDetail::latest()->first();
    return view('frontend.service-trainees', compact('trainees'));
}


public function trustgradeDetails()
{
    $trustgradeDetails = TrustGradeDetails::latest()->first();
    return view('frontend.service-trustgradeDetails', compact('trustgradeDetails'));
}

public function private_sector_academic_specialities()
{
    $privatesectordetails = PrivateSectorDetails::latest()->first();
    return view('frontend.service-private_sector_academic_specialities', compact('privatesectordetails'));
}

public function compare_us()
{
    $compareus = CompareUsDetails::latest()->first();
    return view('frontend.service-compare_us', compact('compareus'));
}


public function for_non_members()
{
    $fornonmembershipdetails = ForNonMembershipDetails::latest()->first();
    return view('frontend.service-for_non_members', compact('fornonmembershipdetails'));
}
}
