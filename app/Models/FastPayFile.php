<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FastPayFile extends Model
{
    protected $fillable = [
        'filename',
        'path',
        'submission_date',
        'total_amount',
        'status',
        'fastpay_response'
    ];
}
