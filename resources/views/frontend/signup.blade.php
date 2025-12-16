
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


<meta name="csrf-token" content="{{ csrf_token() }}">
<input type="hidden" id="userId" value="{{ $id }}">

<section class="application-form-one-sec py-5">
  <div class="container">

    <!-- PROGRESS -->
    <div class="creative-progress mb-4 position-relative">
      <div class="progress bg-light rounded-pill" style="height: 8px;">
        <div class="progress-fill bg-primary rounded-pill" style="width: 0%; height: 100%; transition: width 0.5s;"></div>
      </div>
      <ul class="progress-steps d-flex justify-content-between mt-2 list-unstyled p-0">
        <li class="text-center flex-fill active"><span class="fw-bold">Step 1</span></li>
        <li class="text-center flex-fill"><span class="fw-bold">Step 2</span></li>
      </ul>
    </div>

    <!-- STEP 1 -->
    <div class="form-step" data-step="1">
      <h3 class="mb-4">Step 1: Bank Details Submission</h3>
      <div class="row g-3">

        <div class="col-md-6">
          <label class="form-label">Submission Type</label>
          <select id="submissionType" class="form-select">
            <option value="">Select</option>
            <option value="electronic">Electronic</option>
            <option value="physical">Physical</option>
          </select>
        </div>

        <!-- ELECTRONIC -->
        <div id="electronicFields" class="row g-3 mt-3 d-none">
          <div class="col-md-6">
            <input id="accountHolder" class="form-control" placeholder="Account Holder">
          </div>
          <div class="col-md-6">
            <input id="accountNumber" class="form-control" placeholder="Account Number">
          </div>
          <div class="col-md-6">
            <input id="sortCode" class="form-control" placeholder="Sort Code">
          </div>
        </div>

        <!-- PHYSICAL -->
        <div id="physicalFields" class="row g-3 mt-3 d-none">
          <div class="col-12">
            <p>If multiple signatures are required, a paper mandate must be completed.</p>
            <a href="{{ asset('frontend/assets/img/DDI - DDPU.pdf') }}" target="_blank"
               class="fw-bold text-primary text-decoration-underline">Click here to print the direct debit form</a>
          </div>
          <div class="col-md-6">
            <input id="companyName" class="form-control" placeholder="Company Name">
          </div>
          <div class="col-md-6">
            <input type="file" id="mandateFile" class="form-control" accept=".pdf,.jpg,.png">
          </div>
        </div>

        <div id="stepLoader" class="text-center d-none mt-3">
          <div class="spinner-border text-primary"></div>
          <p class="mt-2">Please wait...</p>
        </div>

        <div class="col-12 mt-3">
          <button id="nextBtn" type="button" class="btn btn-primary btn-lg">Next</button>
        </div>
      </div>
    </div>

    <!-- STEP 2 -->
    <div class="form-step d-none" data-step="2">
      <h3 class="mb-4">Step 2: Confirm & Submit</h3>
      <div class="row">
        <!-- LEFT: Confirmation Details -->
        <div class="col-md-6">
          <div id="confirmBox" class="border p-4 bg-light rounded mb-3" style="min-height:200px;"></div>
          <div class="d-flex gap-2">
            <button id="backBtn" class="btn btn-secondary btn-lg">Back</button>
            <button id="finalSubmitBtn" class="btn btn-success btn-lg">Submit</button>
            <button id="printPdfBtn" class="btn btn-info btn-lg">Print / Download PDF</button>
          </div>
        </div>

        <!-- RIGHT: PDF Instruction Preview -->
        <div class="col-md-6">
          <div id="pdfPreview" class="border p-3 bg-white rounded" style="min-height:400px; overflow:auto;">
            <div style="text-align:center; margin-bottom:20px;">
              <img src="{{ asset('frontend/assets/img/DDPU-logo.png') }}" alt="DDPU" style="max-height:50px;">
              <img src="{{ asset('frontend/assets/img/direct-debit-logo.png') }}" alt="Direct Debit" style="max-height:50px;">
            </div>
            <div id="pdfContent" style="font-size:12px; line-height:1.4;">
              <!-- Filled dynamically by JS -->
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
let currentStep = 1;
let bankName = '';
let branchName = '';
const csrf = document.querySelector('meta[name="csrf-token"]').content;

function showStep(step) {
    document.querySelectorAll('.form-step').forEach(s => {
        s.classList.toggle('d-none', s.dataset.step != step);
    });

    const progressFill = document.querySelector('.progress-fill');
    progressFill.style.width = step == 2 ? '100%' : '50%';

    document.querySelectorAll('.progress-steps li').forEach((li, index) => {
        li.classList.toggle('active', index < step);
    });
}

submissionType.addEventListener('change', () => {
    electronicFields.classList.toggle('d-none', submissionType.value !== 'electronic');
    physicalFields.classList.toggle('d-none', submissionType.value !== 'physical');
});

function generateServiceNumber() {
    const year = new Date().getFullYear();
    const random = Math.floor(Math.random() * 9000) + 1000;
    return `DDPU/${year}/${random}`;
}

async function generatePDF(serviceNumber) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'pt', 'a4');

    const type = submissionType.value;
    const today = new Date().toLocaleDateString('en-GB', {
        day: '2-digit', month: 'long', year: 'numeric'
    });

    let accountName = type === 'electronic' ? accountHolder.value : companyName.value;
    let accountNumberVal = type === 'electronic' ? accountNumber.value : '-';
    let sortCodeVal = type === 'electronic' ? sortCode.value : '-';
    let bankNameVal = type === 'electronic' ? bankName : '-';
    let branchNameVal = type === 'electronic' ? branchName : '-';

    /* ================= HEADER ================= */
    doc.addImage(
        "https://mbihosting.in/ddpu/demo/assets/img/logo/ddpu-logo.jpg",
        "JPEG", 40, 20, 120, 35
    );

    doc.addImage(
        "https://mbihosting.in/ddpu/demo/assets/img/logo/direct-debit-logo.jpg",
        "JPEG", 420, 20, 120, 35
    );

    doc.setFontSize(14);
    doc.setFont(undefined, 'bold');
    doc.text("Direct Debit Instruction", 40, 75);

    /* ================= LEFT COLUMN ================= */
    doc.setFontSize(11);
    doc.setFont(undefined, 'normal');

    let y = 100;
    const lh = 18;

    doc.text(`Name: ${accountName}`, 40, y); y += lh;
    doc.text(`Account Number: ${accountNumberVal}`, 40, y); y += lh;
    doc.text(`Sort Code: ${sortCodeVal}`, 40, y); y += lh;
    doc.text(`Bank: ${bankNameVal}`, 40, y); y += lh;
    doc.text(`Branch: ${branchNameVal}`, 40, y); y += lh;
    doc.text(`Date: ${today}`, 40, y); y += lh;
    doc.text(`Service User Number: ${serviceNumber}`, 40, y);

    /* ================= RIGHT COLUMN ================= */
    const instructionText =
`Instruction to your bank / building society to pay by direct debit.
Service User Number: ${serviceNumber}

Please pay FastPay Ltd Re DDPU Ltd Direct Debits from the account detailed in this instruction subject to the safeguards assured by the Direct Debit Guarantee.

I understand that this instruction may remain with FastPay Ltd Re DDPU Ltd and, if so, details will be passed electronically to my Bank/Building Society.

The following information will appear on your bank statement alongside our collections:

Company Name: DDPU Ltd

You will receive confirmation by email within 3 days.`;

    doc.text(instructionText, 300, 100, { maxWidth: 250 });

    /* ================= GUARANTEE BOX ================= */
    /* ================= GUARANTEE BOX ================= */
const boxY = 300;
const boxX = 40;
const boxW = 515;

doc.setLineWidth(1);
doc.rect(boxX, boxY, boxW, 170);

/* Title */
doc.setFont(undefined, 'bold');
doc.setFontSize(12);
doc.text("Direct Debit Guarantee", boxX + 10, boxY + 20);

/* Logo */
doc.addImage(
    "https://mbihosting.in/ddpu/demo/assets/img/logo/direct-debit-logo.jpg",
    "JPEG",
    boxX + boxW - 120,
    boxY + 5,
    110,
    30
);

/* Body text */
doc.setFont(undefined, 'normal');
doc.setFontSize(10);

const guaranteeText = `
This Guarantee is offered by all Banks and Building Societies that accept instructions to pay Direct Debits.

If there are any changes to the amount, date or frequency of your Direct Debit, FastPay Ltd Re DDPU Ltd will notify you five working days in advance.

If an error is made in the payment of your Direct Debit, you are entitled to a full and immediate refund from your bank.

You can cancel a Direct Debit at any time by contacting your Bank or Building Society.
`.trim();

/* Proper wrapping */
const wrappedText = doc.splitTextToSize(guaranteeText, boxW - 20);

/* Print with line spacing */
doc.text(wrappedText, boxX + 10, boxY + 45, {
    lineHeightFactor: 1.5
});


    /* ================= VIEW / PRINT ================= */
    doc.output('dataurlnewwindow');
}


function showConfirmation(type, serviceNumber, today) {
    let leftHtml = '';
    let rightHtml = '';

    const instructionHtml = `<h4 style="text-align:center;">Instruction to your bank / building society to pay by Direct Debit</h4>
      <p><strong>Service User Number:</strong> ${serviceNumber}</p>
      <p>Please pay FastPay Ltd Re DDPU Ltd Direct Debits from the account detailed in this instruction subject to the safeguards assured by the Direct Debit Guarantee.</p>
      <p>I understand that this instruction may remain with FastPay Ltd Re DDPU Ltd and, if so, details will be passed electronically to my Bank/Building Society.</p>
      <p>The following information will appear on your bank statement alongside our collections:</p>
      <p><strong>Company Name:</strong> DDPU Ltd</p>`;

    if(type === 'electronic') {
        leftHtml = `<h5>Submission Type: Electronic</h5>
          <p><strong>Service Number:</strong> ${serviceNumber}</p>
          <p><strong>Account Holder:</strong> ${accountHolder.value}</p>
          <p><strong>Account Number:</strong> ${accountNumber.value}</p>
          <p><strong>Sort Code:</strong> ${sortCode.value}</p>
          <p><strong>Bank Name:</strong> ${bankName}</p>
          <p><strong>Branch Name:</strong> ${branchName}</p>
          <p><strong>Date:</strong> ${today}</p>`;
    } else {
        leftHtml = `<h5>Submission Type: Physical</h5>
          <p><strong>Service Number:</strong> ${serviceNumber}</p>
          <p><strong>Company Name:</strong> ${companyName.value}</p>
          <p><strong>Uploaded File:</strong> ${mandateFile.files[0].name}</p>
          <p><strong>Date:</strong> ${today}</p>`;
    }

    confirmBox.innerHTML = leftHtml;
    document.getElementById('pdfContent').innerHTML = instructionHtml;

    // Attach PDF generation to button
    document.getElementById('printPdfBtn').onclick = () => generatePDF(serviceNumber);
}

nextBtn.addEventListener('click', async () => {
    const type = submissionType.value;
    const loader = stepLoader;
    const userId = document.getElementById('userId').value;

    if (!type) { Swal.fire({ icon: 'warning', title: 'Select Submission Type' }); return; }

    loader.classList.remove('d-none');
    const today = new Date().toLocaleDateString('en-GB', { day:'2-digit', month:'long', year:'numeric' });
    const serviceNumber = generateServiceNumber();

    if(type === 'electronic') {
        if(!accountHolder.value || !accountNumber.value || !sortCode.value){
            loader.classList.add('d-none');
            Swal.fire({ icon:'warning', title:'All bank fields are required' });
            return;
        }

        try{
            const res = await fetch(`/proxy-bank-validation?sortCode=${encodeURIComponent(sortCode.value)}`);
            const data = await res.json();
            bankName = data.bankName || 'N/A';
            branchName = data.branchName || 'N/A';
        } catch { bankName='Error'; branchName='-'; }

        await fetch('/signup/step1-save',{
            method:'POST',
            headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN': csrf },
            body: JSON.stringify({
                user_id:userId,
                step1_data:{
                    type:'electronic',
                    account_holder:accountHolder.value,
                    account_number:accountNumber.value,
                    sort_code:sortCode.value,
                    bank_name:bankName,
                    branch_name:branchName,
                    service_number:serviceNumber
                }
            })
        });

        showConfirmation('electronic', serviceNumber, today);
    } else {
        if(!companyName.value || mandateFile.files.length === 0){
            loader.classList.add('d-none');
            Swal.fire({ icon:'warning', title:'Enter company name & upload file' });
            return;
        }

        const fd = new FormData();
        fd.append('user_id', userId);
        fd.append('mandate_file', mandateFile.files[0]);
        fd.append('step1_data[type]','physical');
        fd.append('step1_data[company_name]',companyName.value);
        fd.append('step1_data[service_number]',serviceNumber);

        await fetch('/signup/step1-save',{
            method:'POST',
            headers:{ 'X-CSRF-TOKEN': csrf },
            body: fd
        });

        showConfirmation('physical', serviceNumber, today);
    }

    loader.classList.add('d-none');
    await Swal.fire({ icon:"success", title:`Step ${currentStep} Saved Successfully!`, text:"You can continue to next step", timer:1800, showConfirmButton:false });
    currentStep = 2; showStep(2);
});

backBtn.addEventListener('click', ()=>{ currentStep=1; showStep(1); });

finalSubmitBtn.addEventListener('click', async ()=>{
    const res = await fetch('/signup/final-submit',{
        method:'POST',
        headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN': csrf },
        body: JSON.stringify({ user_id: document.getElementById('userId').value })
    }).then(r=>r.json());

    if(res.success){
        await Swal.fire({ icon:"success", title:"Signup Completed!", text:"Your application has been submitted successfully", timer:2000, showConfirmButton:false });
        window.location.href='/';
    } else {
        Swal.fire({ icon:'error', title:'Something went wrong', text:'Please try again.' });
    }
});

showStep(1);
</script>



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


<!-- <script>
let currentStep = 1;
let bankName = '';
let branchName = '';

const steps = document.querySelectorAll('.form-step');
const fill  = document.querySelector('.progress-fill');

function showStep(step) {
    steps.forEach(s => s.style.display = s.dataset.step == step ? 'block' : 'none');
    fill.style.width = step === 2 ? '100%' : '0%';
}

/* ===============================
   BANK API
================================ */
async function fetchBankDetails(sortCode) {
    try {
        const res = await fetch(`/proxy-bank-validation?sortCode=${encodeURIComponent(sortCode)}`);
        const data = await res.json();
        bankName   = data.bankName   || 'N/A';
        branchName = data.branchName || 'N/A';
    } catch {
        bankName = 'Error';
        branchName = '-';
    }
}

/* ===============================
   TYPE CHANGE
================================ */
submissionType.addEventListener('change', function () {
    electronicFields.style.display = this.value === 'electronic' ? 'flex' : 'none';
    physicalFields.style.display   = this.value === 'physical'   ? 'flex' : 'none';
});

/* ===============================
   PDF CLICK MESSAGE
================================ */
document.getElementById('downloadMandate')?.addEventListener('click', () => {
    document.getElementById('downloadStatus').classList.remove('d-none');
});

/* ===============================
   FILE UPLOAD MESSAGE
================================ */
mandateFile?.addEventListener('change', () => {
    if (mandateFile.files.length > 0) {
        document.getElementById('uploadStatus').classList.remove('d-none');
    }
});

/* ===============================
   NEXT BUTTON
================================ */
nextBtn.addEventListener('click', async () => {

    const type   = submissionType.value;
    const loader = document.getElementById('stepLoader');

    if (!type) {
        alert('Please select submission type');
        return;
    }

    loader.style.display = 'block';

    const today = new Date().toLocaleDateString('en-GB', {
        day: '2-digit', month: 'long', year: 'numeric'
    });

    /* ELECTRONIC */
    if (type === 'electronic') {
        if (!accountHolder.value || !accountNumber.value || !sortCode.value) {
            loader.style.display = 'none';
            alert('All bank fields are required');
            return;
        }

        await fetchBankDetails(sortCode.value);

        confirmBox.innerHTML = `
          <h5>Submission Type: Electronic</h5>
          <br>
          <p><strong>Account Holder:</strong> ${accountHolder.value}</p>
          <p><strong>Account Number:</strong> ${accountNumber.value}</p>
          <p><strong>Sort Code:</strong> ${sortCode.value}</p>
          <p><strong>Bank Name:</strong> ${bankName}</p>
          <p><strong>Branch Name:</strong> ${branchName}</p>
          <p><strong>Date:</strong> ${today}</p>
        `;
    }

    /* PHYSICAL */
if (type === 'physical') {

    if (!companyName.value && mandateFile.files.length === 0) {
        loader.style.display = 'none';
        alert('Please enter company name and upload the signed mandate form.');
        return;
    }

    if (!companyName.value) {
        loader.style.display = 'none';
        alert('Please enter the company name.');
        companyName.focus();
        return;
    }

    if (mandateFile.files.length === 0) {
        loader.style.display = 'none';
        alert('Please download, sign and upload the mandate form.');
        mandateFile.focus();
        return;
    }

    // ✅ Success – show step 2
    confirmBox.innerHTML = `
        <h5>Submission Type: Physical</h5>
        <br>
        <p><strong>Company Name:</strong> ${companyName.value}</p>
        <p><strong>Uploaded File:</strong> ${mandateFile.files[0].name}</p>
        <p><strong>Date:</strong> ${today}</p>
    `;
}


    setTimeout(() => {
        loader.style.display = 'none';
        currentStep = 2;
        showStep(currentStep);
    }, 800);
});

/* ===============================
   BACK
================================ */
backBtn.addEventListener('click', () => {
    currentStep = 1;
    showStep(currentStep);
});

showStep(currentStep);
</script>
 -->

</body>

</html>