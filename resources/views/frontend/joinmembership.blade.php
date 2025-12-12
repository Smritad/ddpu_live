<!DOCTYPE html>
<html lang="en">

<head>
 @include('components.frontend.head')
</head>
<style>
    input[type="email"] {
    text-transform: lowercase !important;
}
/* PDF Layout */
.preview-section-title {
    font-weight: bold;
    font-size: 18px;
    margin: 25px 0 10px;
    border-bottom: 2px solid #333;
    padding-bottom: 5px;
    color: #222;
}

.preview-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background: #fff;
}

.preview-table td {
    border: 1px solid #ccc;
    padding: 10px 12px;
    vertical-align: top;
    font-size: 14px;
}

.preview-label {
    width: 30%;
    background: #f2f2f2;
    font-weight: bold;
}

.preview-value {
    width: 70%;
    color: #333;
}

/* Scrollable preview box */
#previewContainer {
    max-height: 420px;      /* adjust height as needed */
    overflow-y: auto;
    padding-right: 10px;    /* avoid scrollbar overlap */
    border: 1px solid #ccc;
    background: #fff;
    border-radius: 6px;
}

/* Optional smooth scrolling */
#previewContainer::-webkit-scrollbar {
    width: 8px;
}
#previewContainer::-webkit-scrollbar-thumb {
    background: #b4b4b4;
    border-radius: 10px;
}
#previewContainer::-webkit-scrollbar-track {
    background: #eee;
}


</style>
<body class="index-page">
<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

  <header id="header" class="header sticky-top">
        @include('components.frontend.header')
  </header>

  <main class="main">
    <section class="ddpu-breadcrumb-sec">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>What is DDPU?</h1>
            <ul class="bread-list">
              <li><a href="{{ route('frontend.index') }}">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">About Us<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">What is DDPU?</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>


   <section class="application-form-one-sec">
    <div class="section-title aos-init aos-animate" data-aos="fade-up">
        <h2>Application for Membership of <br>Doctors and Dentists Protection Union</h2>
    </div>
    <div class="container">
        <div id="progressWrapper" class="creative-progress">
            <div class="progress-line">
                <div class="progress-fill"></div>
            </div>
            <ul class="progress-steps">
                <li class="active" data-step="1"><span>Step 1</span></li>
                <li data-step="2"><span>Step 2</span></li>
                <li data-step="3"><span>Step 3</span></li>
                <li data-step="4"><span>Step 4</span></li>
                <li data-step="5"><span>Step 5</span></li>
                <li data-step="6"><span>Step 6</span></li>
                <li data-step="7"><span>Step 7</span></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div id="form-step-wrap" class="application-form-step-sec">

                    <!-- STEP 1 -->
                    <div id="step1box" class="slider-step first-step af-border-sec" data-next-step="step2Box" data-step="1">
                        <div class="application-form-title-sec creative-med-title">
                            <div class="title-icon"><i class="fa-solid fa-user"></i></div>
                            <h3>Step 1</h3>
                        </div>

                        <div class="app-form-title-subsec"><h4>Your Details</h4></div>

                        <form id="step1Form" class="row g-3">
                            <div class="col-md-6">
                                <select id="gmc-gdc-select-sec" class="form-select" name="gmc_gdc_type">
                                    <option disabled selected>Are your registered with GMC or GDC</option>
                                    <option value="state-gmc">GMC</option>
                                    <option value="gdc">GDC</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="GMC/GDC Registration No."
                                    id="gmc-gdc-registration-number" name="gmc_gdc_number">
                            </div>

                            <div class="col-md-6">
                                <input type="text" class="form-control af-registration-year-picker"
                                    id="af-registration-year-picker" placeholder="Year of above registration (YYYY)"
                                    name="registration_year">
                            </div>

                            <div class="col-md-6">
                                <input type="text" class="form-control af-qualification-year-picker"
                                    id="af-qualification-year-picker" placeholder="Year of qualification (YYYY)"
                                    name="qualification_year">
                            </div>

                            <div class="col-12">
                                <input type="text" class="form-control" id="app-form-specialty" placeholder="Specialty"
                                    name="specialty">
                            </div>

                            <div class="col-12">
                                <input type="text" class="form-control" id="app-form-professional-qualification"
                                    placeholder="Professional Qualification" name="professional_qualification">
                            </div>

                            <hr>

                            <div class="app-form-title-subsec">
                                <h4>Please provide following details as they appear in GMC or GDC record</h4>
                            </div>

                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="First name"
                                    id="app-form-first-name" name="first_name">
                            </div>

                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Middle name"
                                    id="app-form-middle-name" name="middle_name">
                            </div>

                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Last name"
                                    id="app-form-last-name" name="last_name">
                            </div>

                            <div class="col-6">
                                <input type="text" class="form-control app-date-picker"
                                    id="app-form-date-of-birth" placeholder="Date of Birth (DD/MM/YYYY)"
                                    name="date_of_birth">
                            </div>

                            <div class="col-md-6">
                                <select id="gender-select" class="form-select" name="gender">
                                    <option disabled selected>Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <input type="text" class="form-control" id="app-form-address-line-one"
                                    placeholder="Address Line 1" name="address_line_1">
                            </div>

                            <div class="col-6">
                                <input type="text" class="form-control" id="app-form-address-line-two"
                                    placeholder="Address Line 2" name="address_line_2">
                            </div>

                            <div class="col-6">
                                <input type="text" class="form-control" id="app-form-address-line-three"
                                    placeholder="Address Line 3" name="address_line_3">
                            </div>

                            <div class="col-4">
                                <input type="text" class="form-control" id="app-form-city" placeholder="City"
                                    name="city">
                            </div>

                            <div class="col-4">
                                <select class="form-select" id="app-form-country" name="country">
                                    <option disabled selected>Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                             <div class="col-4">
                                <input type="text" class="form-control" id="app-form-postal-code"
                                placeholder="Postal Code" maxlength="10" name="postal-code"
                                oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9\s-]/g,'')">
                            </div>


                            <hr>

                            <div class="app-form-title-subsec">
                                <h4>Address on which you would like to be contacted if different from above</h4>
                            </div>

                            <div class="col-12">
                                <div class="form-check app-form-checkbox-custom-sec">
                                    <input class="form-check-input" type="checkbox" id="same-address-checkbox"
                                        name="same_as_main_address">
                                    <label class="form-check-label" for="same-address-checkbox">
                                        Same As Above Address
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <input type="text" class="form-control" id="contact-address-line-one"
                                    placeholder="Address Line 1" name="contact_address_line_1">
                            </div>

                            <div class="col-6">
                                <input type="text" class="form-control" id="contact-address-line-two"
                                    placeholder="Address Line 2" name="contact_address_line_2">
                            </div>

                            <div class="col-6">
                                <input type="text" class="form-control" id="contact-address-line-three"
                                    placeholder="Address Line 3" name="contact_address_line_3">
                            </div>

                            <div class="col-4">
                                <input type="text" class="form-control" id="contact-city" placeholder="City"
                                    name="contact_city">
                            </div>

                            <div class="col-4">
                                <select class="form-select" id="contact-country" name="contact_country">
                                    <option disabled selected>Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-4">
                                <input type="text" class="form-control" id="contact-postal-code"
                                placeholder="Postal Code" maxlength="10" name="contact_postal_code"
                                oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9\s-]/g,'')">

                            </div>

                            <div class="col-6">
                                <button type="button" value="save-draft" class="form-control app-form-btn">Save Draft</button>
                            </div>

                            <div class="col-6">
                                <button type="button" value="Continue" class="btn-next btn-success form-control app-form-btn">Continue</button>
                            </div>

                        </form>
                    </div>

                   <!-- STEP 2 -->
                        <div id="step2Box" class="slider-step af-border-sec" data-next-step="step3Box" data-back-to="step1Box" data-step="2">
                            <div class="application-form-title-sec creative-med-title">
                                <div class="title-icon"><i class="fa-solid fa-user"></i></div>
                                <h3>Step 2</h3>
                            </div>

                            <div class="app-form-title-subsec"><h4>Telephone Contact Details</h4></div>

                            <form id="step2Form" class="row g-3">

                                <!-- Telephone Day -->
                                <div class="col-md-4">
                                    <input type="tel" class="form-control" id="app-form-telephone-day"
                                        placeholder="Telephone (Day)" minlength="10" maxlength="15"
                                        name="telephone_day"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>

                                <!-- Telephone Evening -->
                                <div class="col-md-4">
                                    <input type="tel" class="form-control" id="app-form-telephone-evening"
                                        placeholder="Telephone (Evening)" minlength="10" maxlength="15"
                                        name="telephone_evening"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>

                                <!-- Mobile Number -->
                                <div class="col-md-4">
                                    <input type="tel" class="form-control" id="app-form-mobile-number"
                                        placeholder="Mobile Number" minlength="10" maxlength="15"
                                        name="mobile_number"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>

                                <div class="app-form-title-subsec"><h4>Security</h4></div>

                                <!-- Primary Email -->
                                <div class="col-md-6">
                                    <input type="email" class="form-control" id="app-form-primary-email"
                                        placeholder="Primary Email" name="primary_email" required>
                                </div>

                                <!-- Secondary Email (Optional) -->
                                <div class="col-md-6">
                                    <input type="email" class="form-control" id="app-form-secondary-email-optional"
                                        placeholder="Secondary Email (Optional)" name="secondary_email">
                                </div>

                                <!-- Username -->
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="app-form-select-username"
                                        placeholder="Enter a Username" name="username" required>
                                </div>

                                <!-- Password -->
                                <div class="col-md-4">
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="app-form-select-password"
                                            placeholder="Enter a Password" name="password" required>
                                        <i class="fa-solid fa-eye toggle-password" data-target="#app-form-select-password" style="cursor:pointer;"></i>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-4">
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="app-form-verify-password"
                                            placeholder="Verify Password" name="confirm_password" required>
                                        <i class="fa-solid fa-eye toggle-password" data-target="#app-form-verify-password" style="cursor:pointer;"></i>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="col-4">
                                    <button type="button" class="form-control btn-back app-form-btn">Previous</button>
                                </div>

                                <div class="col-4">
                                    <button type="button" value="save-draft" class="form-control app-form-btn">Save Draft</button>
                                </div>

                                <div class="col-4">
                                    <button type="button" value="Continue" class="btn-next btn-success form-control app-form-btn">Continue</button>
                                </div>

                            </form>
                        </div>


                    <!-- STEP 3 -->
                    <div id="step3Box" class="slider-step af-border-sec" data-next-step="step4Box" data-back-to="step2Box" data-step="3">

                        <div class="application-form-title-sec creative-med-title">
                            <div class="title-icon"><i class="fa-solid fa-user"></i></div>
                            <h3>Step 3</h3>
                        </div>

                        <div class="app-form-title-subsec"><h4>Job Title and Grade</h4></div>

                        <form id="step3Form" class="row g-3">

                            <div class="col-md-12">
                                <textarea class="form-control app-form-textarea-custom-sec" id="app-form-desc-of-current-role"
                                    placeholder="Description of Current Role" rows="4" name="current_role_description"></textarea>
                            </div>

                            <div class="col-md-6">
                                <select class="form-select" id="emp-status" name="employment_status">
                                    <option disabled selected>Are you employed or self employed ?</option>
                                    <option value="employed">Employed</option>
                                    <option value="self-employed">Self Employed</option>
                                </select>
                            </div>

                            <div class="col-md-6 employed-field">
                                <input type="text" class="form-control" id="current-employer"
                                    placeholder="Enter Current Employer" name="current_employer">
                            </div>

                            <div class="col-md-6 employed-field">
                                <input type="text" class="form-control" id="employment-grade"
                                    placeholder="Enter Grade in which employed" name="employment_grade">
                            </div>

                            <div class="col-md-6 employed-field">
                                <input type="text" class="form-control" id="lead-employer"
                                    placeholder="Lead Employer (If you are a trainee)" name="lead_employer">
                            </div>

                            <div class="col-md-12">
                                <div class="row app-form-custom-btn-row">

                                    <div class="col-4">
                                        <button type="button" value="save-draft" class="form-control btn-back app-form-btn">Previous</button>
                                    </div>

                                    <div class="col-4">
                                        <button type="button" value="save-draft" class="form-control app-form-btn">Save Draft</button>
                                    </div>

                                    <div class="col-4">
                                        <button type="button" value="Continue" class="btn-next btn-success form-control app-form-btn">Continue</button>
                                    </div>

                                </div>
                            </div>

                        </form>
                    </div>

                    <!-- STEP 4 -->
                    <div id="step4Box" class="slider-step af-border-sec" data-next-step="step5Box" data-back-to="step3Box" data-step="4">

                        <div class="application-form-title-sec creative-med-title">
                            <div class="title-icon"><i class="fa-solid fa-user"></i></div>
                            <h3>Step 4</h3>
                        </div>

                        <div class="app-form-title-subsec">
                            <h4>Professional Negligence Indemnity</h4>
                            <p>It is a legal and regulatory requirement [...]</p>
                        </div>

                        <hr>

                        <form id="step4Form" class="row g-3">

                            <div class="col-md-12">
                                <label class="form-label d-block">Do you require Professional Negligence indemnity?</label>

                                <div class="d-flex gap-4 align-items-center">
                                    <div class="form-check app-form-checkbox-custom-sec">
                                        <input class="form-check-input pni-option" type="checkbox" id="pni-yes"
                                            name="pni_required_yes" value="yes">
                                        <label class="form-check-label" for="pni-yes">Yes</label>
                                    </div>

                                    <div class="form-check app-form-checkbox-custom-sec">
                                        <input class="form-check-input pni-option" type="checkbox" id="pni-no"
                                            name="pni_required_no" value="no">
                                        <label class="form-check-label" for="pni-no">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row app-form-custom-btn-row">

                                    <div class="col-4">
                                        <button type="button" value="save-draft"
                                            class="form-control btn-back app-form-btn">Previous</button>
                                    </div>

                                    <div class="col-4">
                                        <button type="button" value="save-draft"
                                            class="form-control app-form-btn">Save Draft</button>
                                    </div>

                                    <div class="col-4">
                                        <button type="button" value="Continue"
                                            class="btn-next btn-success form-control app-form-btn">Continue</button>
                                    </div>

                                </div>
                            </div>

                        </form>
                    </div>

                    <!-- STEP 5 -->
                    <div id="step5Box" class="slider-step af-border-sec" data-next-step="step6Box" data-back-to="step4Box" data-step="5">

                        <div class="application-form-title-sec creative-med-title">
                            <div class="title-icon"><i class="fa-solid fa-user"></i></div>
                            <h3>Step 5</h3>
                        </div>

                        <div class="app-form-title-subsec">
                            <h4>Declaration of Pre-existing professional Issues</h4>
                            <p>We do not provide cover for professional issues [...]</p>
                        </div>

                        <hr>

                        <form id="step5Form" class="row g-3">

                            <div class="col-12">
                                <label class="form-label"><strong>Q.</strong> Please provide details [...]</label>
                                <textarea class="form-control app-form-textarea-custom-sec" id="pre-issue-q31"
                                    rows="4" placeholder="Enter details here..." name="issue_q31"></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><strong>Q.</strong> Are you aware of any matters [...]</label>
                                <textarea class="form-control app-form-textarea-custom-sec" id="pre-issue-q32"
                                    rows="4" placeholder="Enter details here..." name="issue_q32"></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><strong>Q.</strong> Have you been subject to [...]</label>
                                <textarea class="form-control app-form-textarea-custom-sec" id="pre-issue-q33"
                                    rows="4" placeholder="Enter details here..." name="issue_q33"></textarea>
                            </div>

                            <div class="col-md-12">
                                <div class="row app-form-custom-btn-row">

                                    <div class="col-4">
                                        <button type="button" value="save-draft"
                                            class="form-control btn-back app-form-btn">Previous</button>
                                    </div>

                                    <div class="col-4">
                                        <button type="button" value="save-draft"
                                            class="form-control app-form-btn">Save Draft</button>
                                    </div>

                                    <div class="col-4">
                                        <button type="button" value="Continue"
                                            class="btn-next btn-success form-control app-form-btn">Continue</button>
                                    </div>

                                </div>
                            </div>

                        </form>
                    </div>

                    <!-- STEP 6 -->
                    <div id="step6Box" class="slider-step af-border-sec" data-next-step="step7Box" data-back-to="step5Box" data-step="6">

                        <div class="application-form-title-sec creative-med-title">
                            <div class="title-icon"><i class="fa-solid fa-user"></i></div>
                            <h3>Step 6</h3>
                        </div>

                        <div class="app-form-title-subsec"><h4>Claims Information</h4></div>

                        <form id="step6Form" class="row g-3">

                            <div class="col-12">
                                <label class="form-label"><strong>Q.</strong> Have any claims [...]</label>
                                <textarea class="form-control app-form-textarea-custom-sec"
                                    rows="4" placeholder="Enter details here..." name="claims_q1"></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><strong>Q.</strong> Are you aware of any acts [...]</label>
                                <textarea class="form-control app-form-textarea-custom-sec"
                                    rows="4" placeholder="Enter details here..." name="claims_q2"></textarea>
                            </div>

                            <hr>

                            <div class="app-form-title-subsec"><h4>Previous Union or Defence Organisation Membership</h4></div>

                            <div class="col-12">
                                <label class="form-label"><strong>Q.</strong> Have you ever had membership [...]</label>
                                <textarea class="form-control app-form-textarea-custom-sec"
                                    rows="4" placeholder="Enter details here..." name="membership_cancelled"></textarea>
                            </div>

                            <div class="col-12"><p><strong>Q.</strong> Please provide details [...]</p></div>

                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="prev-membership-name"
                                    placeholder="Name of the membership or defence organisation"
                                    name="previous_membership_name">
                            </div>

                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" id="prev-membership-expiry"
                                    placeholder="Expiration Date of membership/policy" name="previous_membership_expiry"
                                    onfocus="this.type='date'" onblur="if(!this.value) this.type='text';">
                            </div>

                            <div class="col-md-12">
                                <div class="row app-form-custom-btn-row">

                                    <div class="col-4">
                                        <button type="button" value="save-draft"
                                            class="form-control btn-back app-form-btn">Previous</button>
                                    </div>

                                    <div class="col-4">
                                        <button type="button" value="save-draft"
                                            class="form-control app-form-btn">Save Draft</button>
                                    </div>

                                    <div class="col-4">
                                        <button type="button" value="Continue"
                                            class="btn-next btn-success form-control app-form-btn">Continue</button>
                                    </div>

                                </div>
                            </div>

                        </form>
                    </div>

                   <!-- STEP 7 (FINAL VERSION) -->
                <div id="step7Box" class="slider-step af-border-sec" data-back-to="step6Box" data-step="7">

                        <div class="application-form-title-sec creative-med-title">
                            <div class="title-icon"><i class="fa-solid fa-user"></i></div>
                            <h3>Step 7</h3>
                        </div>

                        <!-- Preview Section -->
                        <div class="app-form-title-subsec">
                            <h4>Preview Your Application</h4>
                            <p>Please review all information you entered in Steps 1 to 6.</p>
                        </div>

                        <div id="previewContainer" class="preview-summary-box" style="padding:15px; background:#f9f9f9; border-radius:6px;">
                            <!-- Filled by JS -->
                        </div>

                        <hr>

                        <!-- Terms -->
                        <div class="col-12 mb-3">
                            <div class="form-check app-form-checkbox-custom-sec">
                                <input class="form-check-input" type="checkbox" id="terms_checkbox">
                                <label class="form-check-label" for="terms_checkbox">
                                    I agree to the <a href="/terms" target="_blank">Terms & Conditions</a>.
                                </label>
                            </div>
                            <small id="termsError" style="color:red; display:none;">You must accept the terms before submitting.</small>
                        </div>

                        <!-- Buttons -->
                        <div class="col-md-12">
                            <div class="row app-form-custom-btn-row">

                                <div class="col-4">
                                    <button type="button" class="form-control btn-back app-form-btn">Previous</button>
                                </div>

                                <div class="col-4">
                                    <button type="button" value="save-draft" class="form-control app-form-btn">Save Draft</button>
                                </div>

                                <div class="col-4">
                                    <button type="button" value="submit" id="finalSubmitBtn" class="btn-success form-control app-form-btn">
                                        Submit
                                    </button>
                                </div>

                            </div>
                        </div>

                </div>
            </div>
        </div>

    </div>
</section>


     <section class="join-membership-sec">
        <div class="container">
            <div class="row">

            <div class="col-md-8">
                <div class="join-membership-content-sec">
                <h2 class="join-membership-title">{{ $joinmembership->heading }}</h2>
                <p>{{ $joinmembership->description }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="join-membership-btn-sec">
                <a href="#" class="btn-dark btn-lg">
                    <span>Join Now</span>
                </a>
                </div>
            </div>

            </div>
        </div>
   </section>
  </main>
        @include('components.frontend.footer')





  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
   
  <!--<div id="preloader"></div>-->

      @include('components.frontend.main-js')
      <script>
/* ============================================================
=  STEP 7 - PREVIEW GENERATOR
============================================================ */

/* Build preview when entering Step 7 */
document.addEventListener("DOMContentLoaded", function () {

    // Detect when user moves INTO Step 7
    document.querySelectorAll(".btn-next").forEach(btn => {
        btn.addEventListener("click", function () {
            const next = this.closest(".slider-step").dataset.nextStep;
            if (next === "step7Box") {
                generatePreview();
            }
        });
    });
});

  /* Generate the preview (2 columns layout like PDF) */
function generatePreview() {
    const previewBox = document.getElementById("previewContainer");
    previewBox.innerHTML = ""; 

    const fields = document.querySelectorAll(
        "#step1box [name],#step2Box [name],#step3Box [name],#step4Box [name],#step5Box [name],#step6Box [name]"
    );

    let html = `<div class="preview-section-title">Application Summary</div>`;
    html += `<table class="preview-table">`;

    fields.forEach(field => {
        let label = formatLabel(field.name);
        let value = "";

        if (field.type === "checkbox") {
            value = field.checked ? "Yes" : "No";
        } else if (field.type === "file") {
            value = field.files.length ? field.files[0].name : "Not uploaded";
        } else {
            value = field.value.trim() || "<em>Not provided</em>";
        }

        html += `
            <tr>
                <td class="preview-label">${label}</td>
                <td class="preview-value">${value}</td>
            </tr>
        `;
    });

    html += `</table>`;
    previewBox.innerHTML = html;
}




/* Convert "first_name" → "First Name" */
function formatLabel(name) {
    return name
        .replace(/_/g, " ")
        .replace(/\b\w/g, c => c.toUpperCase());
}


/* ============================================================
=  STEP 7 FINAL SUBMIT (No Step 8)
============================================================ */


document.getElementById("finalSubmitBtn").addEventListener("click", async function () {

    // Validate Terms
    if (!document.getElementById("terms_checkbox").checked) {
        document.getElementById("termsError").style.display = "block";
        return;
    }

    document.getElementById("termsError").style.display = "none";

    // Show loading
    Swal.fire({
        title: "Submitting...",
        text: "Please wait",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
    });

    try {
        const fin = await fetch("{{ route('application.submit') }}", {
            method: "POST",
            headers: { 
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        });

        const res = await fin.json();

        if (res.status === "success") {
            Swal.fire({
                icon: "success",
                title: "Application Submitted!",
                text: "Redirecting...",
                timer: 2000,
                showConfirmButton: false
            });

            setTimeout(() => {
                window.location.href = "/Signup-form/" + res.application_id;
            }, 1800);

        } else {
            // Display the backend message exactly as it is
            Swal.fire({
                icon: "error",
                title: "Error",
                text: res.message  // <-- shows "Email already exists..." now
            });
        }

    } catch (err) {
        // Network or unexpected errors
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Server error. Please try again."
        });
    }
});

</script>

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <!-- Show/Hide Script -->
                    <script>
                    document.addEventListener("DOMContentLoaded", function () {

                        const checkbox = document.getElementById("apply_designated_body");
                        const fields = document.getElementById("designatedBodyFields");
                        const fileInput = document.getElementById("last-appraisal-output");

                        checkbox.addEventListener("change", function () {

                            if (this.checked) {
                                fields.style.display = "block";
                                fileInput.setAttribute("required", "required");
                            } else {
                                fields.style.display = "none";
                                fileInput.removeAttribute("required");
                                fileInput.value = "";
                            }

                        });
                    });
                    </script>

<script>
/* =========================================================
=  GLOBAL CONFIG
========================================================= */
let currentStep = 1;
const totalSteps = 7;

const stepBoxes = {
    1:"step1box",2:"step2Box",3:"step3Box",4:"step4Box",
    5:"step5Box",6:"step6Box",7:"step7Box",8:"step8Box"
};


/* =========================================================
=  SHOW/HIDE STEPS (Slider Animation)
========================================================= */
function showStep(step,direction="forward"){
    const box=document.getElementById(stepBoxes[step]); 
    if(!box) return;

    document.querySelectorAll(".slider-step").forEach(el=>{
        if(el!==box){
            el.classList.remove("active");
            el.setAttribute("data-anim",direction==="forward"?"hide-to--left":"hide-to--right");
        }
    });

    box.classList.add("active");
    box.setAttribute("data-anim",direction==="forward"?"show-from--right":"show-from--left");

    updateStepUI(step);
    updateFormHeight();
}


/* =========================================================
=  PROGRESS BAR
========================================================= */
function updateStepUI(step){
    const wrap=document.getElementById("progressWrapper");
    const fill=document.querySelector(".progress-fill");
    const items=document.querySelectorAll(".progress-steps li");

    if(step===8){ wrap.style.display="none"; return;} else wrap.style.display="block";

    fill.style.width=((step-1)/(totalSteps-1))*100+"%";
    items.forEach((li,i)=>{ li.classList.remove("active","completed");
        if(i+1<step) li.classList.add("completed");
        if(i+1===step) li.classList.add("active");
    });
}


/* =========================================================
=  AUTO HEIGHT
========================================================= */
function updateFormHeight(){
    const active=document.querySelector(".slider-step.active");
    if(active) document.getElementById("form-step-wrap").style.minHeight=active.offsetHeight+"px";
}


/* =========================================================
=  ERROR HANDLING
========================================================= */
function showError(id,msg){
    const el=document.getElementById(id); if(!el) return;
    let err=el.nextElementSibling;

    if(!err || !err.classList.contains("error-msg")){
        err=document.createElement("div");
        err.classList.add("error-msg");
        err.style.color="red"; err.style.fontSize="13px";
        el.parentNode.appendChild(err);
    }
    err.innerText=msg; el.classList.add("is-invalid");
}

function clearErrors(){
    document.querySelectorAll(".error-msg").forEach(e=>e.remove());
    document.querySelectorAll(".form-control,.form-select,textarea").forEach(e=>e.classList.remove("is-invalid"));
}
const isEmail=e=>/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e);


/* =========================================================
=  STEP VALIDATION
========================================================= */
function validateStep(step){
    clearErrors(); let valid=true;
    const val=id=>document.getElementById(id)?.value.trim();

    if(step===1){
        if(!val("gmc-gdc-select-sec")){showError("gmc-gdc-select-sec","Required");valid=false;}
        if(!val("gmc-gdc-registration-number")){showError("gmc-gdc-registration-number","Required");valid=false;}
        if(!val("af-registration-year-picker")){showError("af-registration-year-picker","Required");valid=false;}
        if(!val("af-qualification-year-picker")){showError("af-qualification-year-picker","Required");valid=false;}
        if(!val("app-form-first-name")){showError("app-form-first-name","Required");valid=false;}
        if(!val("app-form-last-name")){showError("app-form-last-name","Required");valid=false;}
        if(!val("app-form-date-of-birth")){showError("app-form-date-of-birth","Required");valid=false;}
        if(!val("gender-select")){showError("gender-select","Required");valid=false;}
        if(!val("app-form-address-line-one")){showError("app-form-address-line-one","Required");valid=false;}
        if(!val("app-form-city")){showError("app-form-city","Required");valid=false;}
        if(!val("app-form-country")){showError("app-form-country","Required");valid=false;}
        if(!val("app-form-postal-code")){showError("app-form-postal-code","Required");valid=false;}
    }
    if(step===2){
        if(!val("app-form-primary-email")){showError("app-form-primary-email","Required");valid=false;}
        else if(!isEmail(val("app-form-primary-email"))){showError("app-form-primary-email","Invalid Email");valid=false;}
        if(!val("app-form-select-username")){showError("app-form-select-username","Required");valid=false;}
        if(!val("app-form-select-password")){showError("app-form-select-password","Required");valid=false;}
        if(val("app-form-select-password")!==val("app-form-verify-password")){showError("app-form-verify-password","Password Not Match");valid=false;}
    }
    if(step===3){
        if(!val("app-form-desc-of-current-role")){showError("app-form-desc-of-current-role","Required");valid=false;}
        if(!val("emp-status")){showError("emp-status","Required");valid=false;}
        if(val("emp-status")==="employed"){
            if(!val("current-employer")){showError("current-employer","Required");valid=false;}
            if(!val("employment-grade")){showError("employment-grade","Required");valid=false;}
        }
    }
    if(step===4 && !document.querySelector(".pni-option:checked")){showError("pni-yes","Required");valid=false;}
    if(step===5){
        ["pre-issue-q31","pre-issue-q32","pre-issue-q33"].forEach(id=>{
            if(!val(id)){showError(id,"Required");valid=false;}
        });
    }
    if(step===6){
        if(!val("prev-membership-name")){showError("prev-membership-name","Required");valid=false;}
        if(!val("prev-membership-expiry")){showError("prev-membership-expiry","Required");valid=false;}
    }
    if(step===7){
        if(!val("last-appraisal-date-sec")){showError("last-appraisal-date-sec","Required");valid=false;}
        if(!val("revalidation-date-sec")){showError("revalidation-date-sec","Required");valid=false;}
    }
    return valid;
}



/* =========================================================
=  NEXT BUTTON (MAIN CONTROL with LOADER + SweetAlert)
========================================================= */
document.querySelectorAll(".btn-next").forEach(btn=>{
    btn.addEventListener("click",async()=>{

        if(!validateStep(currentStep)) return;

        const box=document.querySelector(`.slider-step[data-step='${currentStep}']`);
        const form=box.querySelector("form");
        const final=(btn.value==="submit" && currentStep===7);

        let fd=new FormData(); 
        fd.append("step",currentStep);

        // append fields automatically
        form.querySelectorAll("[name]").forEach(inp=>{
            if(inp.type==="file" && inp.files.length>0) fd.append(`data[${inp.name}]`,inp.files[0]);
            else if(inp.type==="checkbox") fd.append(`data[${inp.name}]`,inp.checked?1:0);
            else fd.append(`data[${inp.name}]`,inp.value);
        });

        // ---- Show Loader ----
        Swal.fire({
            title: "Saving...",
            text: "Please wait",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
        });

        const save=await fetch("{{ route('application.saveStep') }}",{
            method:"POST",
            headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}"},
            body:fd
        });

        const res=await save.json();

        if(res.status!=="success"){
            Swal.fire("Error","Something went wrong!","error");
            return;
        }

        // ---- STEP SAVE SUCCESS SweetAlert ----
        await Swal.fire({
            icon:"success",
            title:`Step ${currentStep} Saved Successfully!`,
            text:"You can continue to next step",
            timer:1800,
            showConfirmButton:false
        });

        // ---- If Final Step Submit ----
        if(final){
            const fin=await fetch("{{route('application.submit')}}",{
                method:"POST",
                headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}"}
            });
            const ok=await fin.json();

            if(ok.status==="success"){
                Swal.fire({
                    icon:"success",
                    title:"Application Submitted Successfully!",
                    text:"Thank you for completing the process",
                    timer:2200,
                    showConfirmButton:false
                });
                showStep(8,"forward");
            }
            return;
        }

        // ---- Go to Next Step AFTER Sweet Alert ----
        currentStep++;
        showStep(currentStep,"forward");
    });
});



/* =========================================================
=  BACK BUTTON
========================================================= */
document.querySelectorAll(".btn-back").forEach(btn=>{
    btn.addEventListener("click",()=>{
        if(currentStep>1){currentStep--;showStep(currentStep,"backward");}
    });
});




// =====================
// TOAST FUNCTION
// =====================
function showToast(msg){
    const c=document.getElementById("toast-container");
    const t=document.createElement("div");
    t.classList.add("toast"); t.innerText=msg; c.appendChild(t);
    setTimeout(()=>t.classList.add("show"),100);
    setTimeout(()=>{t.classList.remove("show"); setTimeout(()=>t.remove(),500);},3000);
}

// =====================
// SAVE DRAFT WITH 24 HOURS EXPIRY
// =====================
function saveDraft(step, data) {
    const timestamp = new Date().getTime(); // current timestamp in ms
    const draft = {
        step: step,
        data: data,
        savedAt: timestamp
    };
    localStorage.setItem("applicationDraft", JSON.stringify(draft));
    showToast("Draft saved successfully!");
}

// =====================
// LOAD DRAFT IF WITHIN 24 HOURS
// =====================
function loadDraft() {
    const draft = JSON.parse(localStorage.getItem("applicationDraft") || "{}");
    if(!draft.savedAt) return null;

    const now = new Date().getTime();
    const diff = now - draft.savedAt;

    if(diff > 24*60*60*1000){ // older than 24 hours
        localStorage.removeItem("applicationDraft");
        return null;
    }

    return draft;
}

// =====================
// HOOK SAVE DRAFT BUTTONS
// =====================
document.querySelectorAll('button[value="save-draft"]').forEach(btn=>{
    btn.addEventListener("click", ()=>{
        const stepBox = btn.closest(".slider-step");
        const step = parseInt(stepBox.dataset.step);
        const form = stepBox.querySelector("form");

        if(!form) return;

        let formData = {};
        form.querySelectorAll("[name]").forEach(input=>{
            if(input.type === "checkbox") formData[input.name] = input.checked ? 1 : 0;
            else formData[input.name] = input.value;
        });

        saveDraft(step, formData);
    });
});

// =====================
// ON PAGE LOAD, RESTORE DRAFT
// =====================
window.addEventListener("DOMContentLoaded", ()=>{
    const draft = loadDraft();
    if(!draft) return;

    const stepBox = document.querySelector(`.slider-step[data-step="${draft.step}"]`);
    if(!stepBox) return;

    const form = stepBox.querySelector("form");
    if(!form) return;

    Object.keys(draft.data).forEach(name=>{
        const input = form.querySelector(`[name="${name}"]`);
        if(!input) return;
        if(input.type === "checkbox") input.checked = draft.data[name] == 1;
        else input.value = draft.data[name];
    });

   // showToast("Draft restored from last session!");
});




/* =========================================================
=  PASSWORD TOGGLE
========================================================= */
document.querySelectorAll(".toggle-password").forEach(i=>{
    i.addEventListener("click",()=>{
        const inp=document.querySelector(i.dataset.target);
        inp.type=inp.type==="password"?"text":"password";
        i.classList.toggle("fa-eye-slash");
    });
});


/* =========================================================
=  COPY ADDRESS
========================================================= */
document.getElementById("same-address-checkbox")?.addEventListener("change",function(){
    const copy=k=>document.querySelector(`#contact-${k}`).value=document.querySelector(`#app-form-${k.replace(/-/g,"-")}`)?.value;
    if(this.checked){
        ["address-line-one","address-line-two","address-line-three","city","country","postal-code"].forEach(copy);
    }else{
        ["contact-address-line-one","contact-address-line-two","contact-address-line-three","contact-city","contact-country","contact-postal-code"].forEach(id=>document.getElementById(id).value="");
    }
});


/* =========================================================
=  EMPLOYMENT Toggle
========================================================= */
document.getElementById("emp-status")?.addEventListener("change",function(){
    document.querySelectorAll(".employed-field").forEach(e=>e.classList.toggle("d-none",this.value!=="employed"));
});


/* =========================================================
=  PNI Control
========================================================= */
document.querySelectorAll(".pni-option").forEach(o=>{
    o.addEventListener("change",()=>document.querySelectorAll(".pni-option").forEach(x=>{if(x!==o)x.checked=false;}));
});

/* =========================================================
=  Postal Code
========================================================= */
document.querySelectorAll('input[name="postal_code"], input[name="contact_postal_code"]').forEach(input => {
    input.addEventListener('blur', () => input.value = input.value.trim());
});

/* =========================================================
=  DATE PICKERS
========================================================= */
function setPicker(className,type){
    const i=document.querySelector(`.${className}`);
    if(i){i.addEventListener("focus",()=>i.type=type);i.addEventListener("blur",()=>{if(!i.value)i.type="text";});}
}
setPicker("app-date-picker","date");
setPicker("af-registration-year-picker","month");
setPicker("af-qualification-year-picker","month");

showStep(1);
</script>



</body>

</html>