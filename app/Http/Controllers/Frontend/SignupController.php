<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Signupform;


class SignupController extends Controller
{
     public function index($id)
{
    return view('frontend.signup', compact('id'));
}

}