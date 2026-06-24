<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutusTestimonials extends Model
{
    use SoftDeletes;

    protected $table = 'aboutus_testimonials';

    protected $fillable = [
        'banner_image',
        'items',
        'created_by',
        'updated_by',
        'deleted_by',
        
    ];

    protected $casts = [
        'items' => 'array'
    ];
}
