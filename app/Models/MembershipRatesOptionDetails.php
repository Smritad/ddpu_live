<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
class MembershipRatesOptionDetails extends Model
{
        use SoftDeletes;

    protected $table = 'membership_rates_details';

   protected $fillable = [
    'banner_image',
    'subscription_heading',
    'subscription_description',
    'options',
    'created_by'
];

protected $casts = [
    'options' => 'array',
];

}
