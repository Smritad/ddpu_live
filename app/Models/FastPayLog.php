<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FastPayLog extends Model
{
    protected $fillable = [
        'action',
        'filename',
        'request_payload',
        'response_payload',
        'status',
    ];
}
