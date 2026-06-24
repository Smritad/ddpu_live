<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
</head>

<body>

@include('components.backend.header')
@include('components.backend.sidebar')

<style>
.remove-img {
    position: absolute;
    top: -10px;
    right: -10px;
    background: red;
    color: #fff;
    font-size: 20px;
    width: 28px;
    height: 28px;
    text-align: center;
    border-radius: 50%;
    cursor: pointer;
    line-height: 28px;
    font-weight: bold;
    z-index: 10;
}

</style>
<style>
.remove-icon-btn {
    display: none;
    justify-content: center;
    align-items: center;
    position: absolute;
    top: -8px;
    right: -8px;
    background: #dc3545;
    color: #fff;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    font-size: 14px;
    cursor: pointer;
    font-weight: bold;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

.remove-icon-btn:hover {
    background: #b02a37;
}
</style>

<div class="page-body">
<div class="container-fluid">

    <!-- PAGE TITLE -->
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Add Membership benefits Details Form</h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('membership-benefits-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Membership benefits Details</li>
                </ol>
            </div>
        </div>
    </div>

  
<div class="card mt-3">
    <div class="card-header">
         <h4>Membership benefits</h4>
    </div>

    <div class="card-body">
        <form class="row g-4"
              action="{{ route('membership-benefits-details.store') }}"
              method="POST"
              enctype="multipart/form-data">
        @csrf

        <!-- ================= BANNER IMAGE ================= -->
        <div class="col-md-12">
            <label class="form-label fw-semibold">
                Banner Image <span class="text-danger">*</span>
            </label>

            <input type="file"
                   class="form-control"
                   name="banner_image"
                   accept=".jpg,.jpeg,.png,.webp"
                   required
                   onchange="previewImage(this, 'bannerPreview', 'bannerSize', 'removeBannerBtn')">

            <div class="position-relative d-inline-block mt-2">
                <img id="bannerPreview"
                     width="150"
                     style="display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">

                <span id="removeBannerBtn"
                      onclick="removeImage('banner_image','bannerPreview','bannerSize','removeBannerBtn')"
                      style="display:none; cursor:pointer; position:absolute; top:-8px; right:-8px;
                             background:#dc3545; color:#fff; border-radius:50%;
                             width:22px; height:22px; text-align:center;
                             font-size:14px; line-height:22px;">
                    ×
                </span>
            </div>

            <small id="bannerSize" class="text-muted d-block"></small>
        </div>

               
      <div class="col-md-6">
    <label class="form-label fw-semibold">
        Heading <span class="text-danger">*</span>
    </label>

    <input type="text"
           name="heading"
           class="form-control"
           value="{{ old('heading', $data->heading ?? '') }}"
           placeholder="Enter heading"
           required>
</div>

        <!-- ================= MAIN IMAGE ================= -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">
                Main Image <span class="text-danger">*</span>
            </label>

            <input type="file"
                   class="form-control"
                   name="main_image"
                   accept=".jpg,.jpeg,.png,.webp"
                   required
                   onchange="previewImage(this, 'mainPreview', 'mainSize', 'removeMainBtn')">

            <div class="position-relative d-inline-block mt-2">
                <img id="mainPreview"
                     width="150"
                     style="display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">

                <span id="removeMainBtn"
                      onclick="removeImage('main_image','mainPreview','mainSize','removeMainBtn')"
                      style="display:none; cursor:pointer; position:absolute; top:-8px; right:-8px;
                             background:#dc3545; color:#fff; border-radius:50%;
                             width:22px; height:22px; text-align:center;
                             font-size:14px; line-height:22px;">
                    ×
                </span>
            </div>

            <small id="mainSize" class="text-muted d-block"></small>
        </div>
        

        <!-- ================= DESCRIPTION ================= -->
        <div class="col-md-12">
            <label class="form-label fw-semibold">
                Description <span class="text-danger">*</span>
            </label>

            <textarea name="description"
          id="editor"
          class="form-control"
          rows="6"></textarea>

        </div>
        <br>
        <div class="col-md-12 mt-4">
            
            
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">

            <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">
                <i class="fa fa-plus"></i> Add More
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0" id="itemsTable">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="180">Icon</th>
                            <th width="200">Heading</th>
                            
                            <th width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center"></tbody>
                </table>
            </div>
        </div>
    </div>
    
   <div class="col-md-12">
                    <label class="form-label fw-semibold">Benefit Description <span class="text-danger">*</span></label>
                    <textarea name="benefits_description" id="editor1"></textarea>

                </div>

</div>
        <!-- ================= SUBMIT ================= -->
        <div class="col-12 text-end">
            <button class="btn btn-primary px-4" type="submit">
                Submit
            </button>
        </div>

        </form>
    </div>
</div>




</div>
</div>

@include('components.backend.footer')
@include('components.backend.main-js')
<script>
let rowCount = 0;

function addRow() {

    let row = `
    <tr>
        <td>
            <input type="file" name="items[${rowCount}][icon]" 
                   class="form-control form-control-sm"
                   accept=".jpg,.jpeg,.png,.webp"
                   onchange="previewItemImage(this, ${rowCount})" required>

            <div class="position-relative mt-2 d-inline-block">
                <img id="itemPreview${rowCount}" width="60"
                     style="display:none; border-radius:6px; border:1px solid #ddd; padding:3px;">

                <span onclick="removeItemImage(${rowCount})"
                      id="removeItemBtn${rowCount}"
                      class="remove-icon-btn">
                    &times;
                </span>
            </div>

            <small id="itemSize${rowCount}" class="text-muted d-block"></small>
        </td>

        <td>
            <input type="text" name="items[${rowCount}][heading]"
                   class="form-control form-control-sm" required>
        </td>

       
        <td>
            <button type="button"
                    class="btn btn-sm btn-outline-danger"
                    onclick="removeRow(this)">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>`;

    document.querySelector('#itemsTable tbody')
            .insertAdjacentHTML('beforeend', row);

    rowCount++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}

function previewItemImage(input, id) {

    const file = input.files[0];
    const preview = document.getElementById('itemPreview'+id);
    const sizeText = document.getElementById('itemSize'+id);
    const removeBtn = document.getElementById('removeItemBtn'+id);

    if (file) {

        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
            removeBtn.style.display = "flex";
        };

        reader.readAsDataURL(file);

        const sizeKB = (file.size / 1024).toFixed(2);
        sizeText.innerHTML = "Size: " + sizeKB + " KB";
    }
}

function removeItemImage(id) {
    document.getElementById('itemPreview'+id).style.display = "none";
    document.getElementById('removeItemBtn'+id).style.display = "none";
    document.getElementById('itemSize'+id).innerHTML = "";
}
</script>

<script>
function previewImage(input, previewId, sizeId, removeBtnId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const sizeText = document.getElementById(sizeId);
    const removeBtn = document.getElementById(removeBtnId);

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
            removeBtn.style.display = "block";
        };

        reader.readAsDataURL(file);

        // Show File Size
        const sizeKB = (file.size / 1024).toFixed(2);
        sizeText.innerHTML = "File Size: " + sizeKB + " KB";
    }
}

function removeImage(inputName, previewId, sizeId, removeBtnId) {
    const input = document.querySelector("input[name='"+inputName+"']");
    const preview = document.getElementById(previewId);
    const sizeText = document.getElementById(sizeId);
    const removeBtn = document.getElementById(removeBtnId);

    input.value = "";
    preview.src = "";
    preview.style.display = "none";
    sizeText.innerHTML = "";
    removeBtn.style.display = "none";
}
</script>


</body>
</html>
