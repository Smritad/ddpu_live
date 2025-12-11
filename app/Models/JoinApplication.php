<?php
// app/Models/Application.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'gmc_gdc', 'gmc_gdc_registration', 'registration_year', 'qualification_year',
        'specialty', 'professional_qualification', 'first_name', 'middle_name', 'last_name',
        'dob', 'gender', 'address', 'contact_address', 'telephone_day', 'telephone_evening', 
        'mobile', 'primary_email', 'secondary_email', 'username', 'password', 'job_description',
        'employment_status', 'current_employer', 'employment_grade', 'lead_employer',
        'pni_required', 'pre_existing_issues', 'claims_info', 'previous_memberships', 'designated_body'
    ];

    protected $casts = [
        'address' => 'array',
        'contact_address' => 'array',
        'pre_existing_issues' => 'array',
        'claims_info' => 'array',
        'previous_memberships' => 'array',
        'designated_body' => 'array',
    ];
}
