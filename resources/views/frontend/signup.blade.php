
<!DOCTYPE html>
<html lang="en">

<head>
   @include('components.frontend.head')
</head>

<body class="index-page">
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
              <li><a href="./">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">About Us<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">What is DDPU?</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>


<section class="application-form-one-sec">
  <div class="section-title" data-aos="fade-up">
    <h2>Application for Membership of <br>Doctors and Dentists Protection Union</h2>
  </div>

  <div class="container">

    <!-- Progress Bar -->
    <div id="progressWrapper" class="creative-progress mb-4">
      <div class="progress-line"><div class="progress-fill"></div></div>
      <ul class="progress-steps">
        <li class="active" data-step="1"><span>Step 1</span></li>
        <li data-step="2"><span>Step 2</span></li>
      </ul>
    </div>

    <!-- Steps Wrapper -->
    <div id="form-step-wrap">
   <input type="text" name="application_id" value="{{ $id }}">

      <!-- STEP 1 -->
      <div class="form-step" data-step="1">
        <h3 class="step-title">Step 1: Bank Details Submission</h3>

        <form class="row g-3">

          <!-- Submission Type -->
          <div class="col-md-6">
            <label class="form-label">Choose Submission Type</label>
            <select id="submission-type" class="form-select" required>
              <option disabled selected>Select type</option>
              <option value="electronic">Electronic Form</option>
              <option value="physical">Physical Form</option>
            </select>
          </div>

          <!-- Electronic Section -->
          <div id="electronic-fields" class="row g-3 mt-2" style="display:none;">
            <div class="col-md-6">
              <label class="form-label">Name(s) of Account Holder(s)</label>
              <input type="text" class="form-control" name="account_holder">
            </div>
            <div class="col-md-6">
              <label class="form-label">Bank/Building Society Account Number</label>
              <input type="text" class="form-control" name="account_number">
            </div>
            <div class="col-md-6">
              <label class="form-label">Branch Sort Code</label>
              <input type="text" class="form-control" name="sort_code">
            </div>
          </div>

          <!-- Physical Section -->
          <div id="physical-fields" class="row g-3 mt-2" style="display:none;">
            <div class="col-md-6">
              <label class="form-label">Company Name</label>
              <input type="text" class="form-control" name="company_name">
            </div>

            <div class="col-12">
              <p class="info-text">
                If your company account requires more than one signature, <br>
                a paper mandate must be completed and returned to us.
              </p>

              <a href="{{ asset('frontend/assets/img/DDI - DDPU.pdf') }}" target="_blank" class="btn btn-primary mt-2">
                            Click here to print the direct debit form
                        </a>

            </div>

            <!-- Upload Scanned Form -->
            <div class="col-md-6 mt-3">
              <label class="form-label">Upload Scanned Mandate</label>
              <input type="file" class="form-control" name="scan_file">
            </div>
          </div>

          <!-- Next -->
          <div class="col-12 mt-4">
            <button type="button" class="btn btn-primary btn-next">Next</button>
          </div>

        </form>
      </div>

      <!-- STEP 2 -->
      <div class="form-step" data-step="2" style="display:none;">
        <h3 class="step-title">Step 2: Confirm and Print</h3>

        <div id="confirmation-content" class="p-3 border rounded bg-light mb-3"></div>

        <button type="button" class="btn btn-secondary btn-back">Previous</button>
        <button type="submit" class="btn btn-success">Submit</button>
      </div>

    </div>

  </div>
</section>


    <section class="join-membership-sec">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="join-membership-content-sec">
              <h2 class="join-membership-title">Join Membership</h2>
              <p>Our Membership Service Gives The Opportunity To Get All Our Services As Benefits.</p>
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

  <!-- Vendor JS Files -->
   @include('components.frontend.main-js')
<script>let currentStep = 1;
const totalSteps = 2;

function updateStepUI(step) {
    const fill = document.querySelector(".progress-fill");
    const items = document.querySelectorAll(".progress-steps li");

    let percent = ((step - 1) / (totalSteps - 1)) * 100;
    fill.style.width = percent + "%";

    items.forEach((item, index) => {
        item.classList.remove("active", "completed");
        if(index + 1 < step) item.classList.add("completed");
        if(index + 1 === step) item.classList.add("active");
    });

    document.querySelectorAll(".form-step").forEach(s => {
        s.style.display = (parseInt(s.dataset.step) === step) ? "block" : "none";
    });

    if(step === 2){
        const type = document.getElementById("submission-type").value;
        let html = "";

        if(type === "electronic"){
            html = `
                <p><strong>Type:</strong> Electronic Form</p>
                <p><strong>Account Holder:</strong> ${document.querySelector('[name="account_holder"]').value}</p>
                <p><strong>Account Number:</strong> ${document.querySelector('[name="account_number"]').value}</p>
                <p><strong>Sort Code:</strong> ${document.querySelector('[name="sort_code"]').value}</p>
            `;
        } else {
            html = `
                <p><strong>Type:</strong> Physical Form</p>
                <p><strong>Company Name:</strong> ${document.querySelector('[name="company_name"]').value}</p>
            `;
        }

        document.getElementById("confirmation-content").innerHTML = html;
    }
}

document.querySelector(".btn-next").addEventListener("click", () => {
    if(!document.getElementById("submission-type").value){
        alert("Please select submission type");
        return;
    }
    currentStep = 2;
    updateStepUI(currentStep);
});

document.querySelector(".btn-back").addEventListener("click", () => {
    currentStep = 1;
    updateStepUI(currentStep);
});

document.getElementById("submission-type").addEventListener("change", function() {
    document.getElementById("electronic-fields").style.display =
        this.value === "electronic" ? "flex" : "none";

    document.getElementById("physical-fields").style.display =
        this.value === "physical" ? "block" : "none";
});

updateStepUI(currentStep);
</script>
</body>

</html>