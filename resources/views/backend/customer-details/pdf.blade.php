<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Member Profile PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 0.95rem;
            color: #333;
            margin: 1rem;
        }
        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #0d6efd;
        }
        .section {
            margin-bottom: 1.5rem;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            overflow: hidden;
            box-shadow: 0 0 4px rgba(0,0,0,0.05);
        }
        .section-header {
            background-color: #0d6efd;
            color: #fff;
            padding: 0.5rem 1rem;
            font-weight: 600;
        }
        .section-body {
            padding: 1rem;
        }
        .field-label {
            font-weight: 600;
        }
        .field-value {
            margin-bottom: 0.5rem;
        }
        .row > .col-6 {
            padding-bottom: 0.5rem;
        }
        textarea[readonly] {
            width: 100%;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 0.4rem;
            resize: none;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<h2  style="color:#113163">Member Profile</h2>

{{-- Personal & Professional Details --}}
@php
    $step3 = is_array($member->step3) ? $member->step3 : json_decode($member->step3, true);
    $step4 = is_array($member->step4) ? $member->step4 : json_decode($member->step4, true);
    $step5 = is_array($member->step5) ? $member->step5 : json_decode($member->step5, true);
    $step6 = is_array($member->step6) ? $member->step6 : json_decode($member->step6, true);
@endphp

<div class="section">
    <div class="section-header" style="background-color:#113163">Step 1: Personal Details</div>
    <div class="section-body row">
        <div class="col-6 field-value"><span class="field-label">Name:</span> {{ $step1['first_name'] ?? '' }} {{ $step1['middle_name'] ?? '' }} {{ $step1['last_name'] ?? '' }}</div>
        <div class="col-6 field-value"><span class="field-label">Date of Birth:</span> {{ $step1['date_of_birth'] ?? 'NA' }}</div>
        <div class="col-6 field-value"><span class="field-label">Gender:</span> {{ $step1['gender'] ?? 'NA' }}</div>
        <div class="col-6 field-value"><span class="field-label">Postal Code:</span> {{ $step1['contact_postal_code'] ?? 'NA' }}</div>
        <div class="col-6 field-value"><span class="field-label">Address1:</span> {{ $step1['address_line_1'] ?? 'NA' }}, {{ $step1['address_line_2'] ?? 'NA' }}, {{ $step1['city'] ?? 'NA' }}, {{ $step1['country'] ?? 'NA' }}</div>
            <div class="col-6 field-value"><span class="field-label">Address2:</span> {{ $step1['address_line_1'] ?? 'NA' }}</div>
                    <div class="col-6 field-value"><span class="field-label">City:</span> {{ $step1['contact_city'] ?? 'NA' }}</div>
                    <div class="col-6 field-value"><span class="field-label">Country:</span> {{ $step1['contact_country'] ?? 'NA' }}</div>


    </div>
</div>

<div class="section" >
    <div class="section-header"  style="background-color:#113163">Step 1: Professional Details</div>
    <div class="section-body row">
        <div class="col-6 field-value"><span class="field-label">GMC/GDC Number:</span> {{ $step1['gmc_gdc_number'] ?? 'NA' }}</div>
        <div class="col-6 field-value"><span class="field-label">Specialty:</span> {{ $step1['specialty'] ?? 'NA' }}</div>
        <div class="col-6 field-value"><span class="field-label">Professional Qualification:</span> {{ $step1['professional_qualification'] ?? 'NA' }}</div>
    </div>
</div>

<div class="section">
    <div class="section-header"  style="background-color:#113163">Step 2: Contact Details</div>
    <div class="section-body row">
        <div class="col-6 field-value"><span class="field-label">Mobile:</span> {{ $step2['mobile_number'] ?? 'NA' }}</div>
        <div class="col-6 field-value"><span class="field-label">Email:</span> {{ $step2['primary_email'] ?? 'NA' }}</div>
        <div class="col-6 field-value"><span class="field-label">Telephone (Day):</span> {{ $step2['telephone_day'] ?? 'NA' }}</div>
        <div class="col-6 field-value"><span class="field-label">Telephone (Evening):</span> {{ $step2['telephone_evening'] ?? 'NA' }}</div>
    </div>
</div>

<div class="section">
    <div class="section-header"  style="background-color:#113163">Step 3: Job Title & Grade</div>
    <div class="section-body">
        <div class="field-value"><span class="field-label">Current Role Description:</span>
            <textarea readonly rows="3">{{ $step3['current_role_description'] ?? 'NA' }}</textarea>
        </div>
        <div class="row">
            <div class="col-6 field-value"><span class="field-label">Employment Status:</span> {{ $step3['employment_status'] ?? 'NA' }}</div>
            <div class="col-6 field-value"><span class="field-label">Current Employer:</span> {{ $step3['current_employer'] ?? 'NA' }}</div>
            <div class="col-6 field-value"><span class="field-label">Employment Grade:</span> {{ $step3['employment_grade'] ?? 'NA' }}</div>
            <div class="col-6 field-value"><span class="field-label">Lead Employer:</span> {{ $step3['lead_employer'] ?? 'NA' }}</div>
        </div>
    </div>
</div>

<div class="section">
    <div class="section-header"  style="background-color:#113163">Step 4: Professional Negligence Indemnity</div>
    <div class="section-body">
        <div class="field-value"><span class="field-label">Requires PNI:</span> 
            @if(!empty($step4['pni_required_yes']) && $step4['pni_required_yes'] == "1") Yes
            @elseif(!empty($step4['pni_required_no']) && $step4['pni_required_no'] == "1") No
            @else N/A @endif
        </div>
    </div>
</div>

<div class="section">
    <div class="section-header"  style="background-color:#113163">Step 5: Pre-existing Professional Issues</div>
    <div class="section-body">
        <div class="field-value"><span class="field-label">Q1:Please provide details of any concerns raised about your conduct, capability or health in the past five (5) years. This should include any formal and/or disciplinary investigation by your contracting body, your employer or those who hold your performer’s list registration.</span>
            <textarea readonly rows="3">{{ $step5['issue_q31'] ?? 'NA' }}</textarea>
        </div>
        <div class="field-value"><span class="field-label">Q2:Are you aware of any matters that may result in or have resulted in a claim or complaint being made against you? Please provide full details. Not disclosing information that we consider relevant may invalidate your membership. Therefore, if you are unsure if certain information you have would qualify to be stated then please do state that here:</span>
            <textarea readonly rows="3">{{ $step5['issue_q32'] ?? 'NA' }}</textarea>
        </div>
        <div class="field-value"><span class="field-label">Q3:Have you been subject to any Employer’s disciplinary investigation, inquiry or other proceedings, GMC/GDC investigation, inquiry or other proceedings, Coroners’ Inquest or Fatal Accident Inquiry and/or criminal prosecution in the past ten (10) years?</span>
            <textarea readonly rows="3">{{ $step5['issue_q33'] ?? 'NA' }}</textarea>
        </div>
    </div>
</div>

<div class="section">
    <div class="section-header"  style="background-color:#113163">Step 6: Claims & Previous Membership</div>
    <div class="section-body">
        <div class="field-value"><span class="field-label">Claims Q1:Have any claims or complaints relating to your professional work been made or threatened against you in the past three (3) years? If so, please provide details:</span>
            <textarea readonly rows="3">{{ $step6['claims_q1'] ?? 'NA' }}</textarea>
        </div>
        <div class="field-value"><span class="field-label">Claims Q2:Are you aware of any acts, errors, omissions, incidents, events or circumstances which may give rise to a claim, investigation or complaint against you? If so, please provide details:</span>
            <textarea readonly rows="3">{{ $step6['claims_q2'] ?? 'NA' }}</textarea>
        </div>
        <div class="row">
            <div class="col-6 field-value"><span class="field-label">Have you ever had membership or cover cancelled, declined or refused to be renewed by a professional membership organisation or provider of professional indemnity? If so, please provide details:</span>
                <textarea readonly rows="2">{{ $step6['membership_cancelled'] ?? 'NA' }}</textarea>
            </div>
            <div class="col-6 field-value"><span class="field-label">Previous Membership Name:</span> {{ $step6['previous_membership_name'] ?? 'NA' }}</div>
            <div class="col-6 field-value"><span class="field-label">Previous Membership Expiry:</span> {{ $step6['previous_membership_expiry'] ?? 'NA' }}</div>
        </div>
    </div>
</div>
</div>

</body>
</html>
