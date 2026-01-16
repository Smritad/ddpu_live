<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class CustomerBounce extends Model
{
    protected $fillable = [
        'dd_reference', 'sort_code', 'account_number', 'submission_date', 'amount', 'bacs_code', 'account_name', 'error_code', 'error_code_description',
    ];

    protected $casts = [
        'submission_date' => 'datetime',
        'amount' => 'decimal:2',
    ];
}