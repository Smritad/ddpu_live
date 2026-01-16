<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Customer extends Model
{
    protected $fillable = [
        'dd_reference', 'status', 'account_name', 'account_number', 'sort_code', 'suspension_date', 'collections',
    ];

    protected $casts = [
        'collections' => 'array',
        'suspension_date' => 'datetime',
    ];
}