<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_path',
        'collection_date',
        'uploaded_date',
        'notes',
        'total_amount',
        'status',
        'fastpay_response',
        'fastpay_file_id',
    ];

    protected $casts = [
        'collection_date' => 'date',
        'uploaded_date'   => 'datetime',
        'total_amount'    => 'decimal:2',
        'fastpay_response' => 'array', // if you want to access as array
    ];

    // Relationship: One File has many Details
    public function details()
    {
        return $this->hasMany(FileDetail::class);
    }

    // Optional: formatted total
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount, 2);
    }
}