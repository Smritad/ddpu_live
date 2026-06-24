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

<div class="page-body">
<div class="container-fluid">

    <!-- PAGE TITLE -->
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Add Membership Details Form</h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dentists-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Membership Details</li>
                </ol>
            </div>
        </div>
    </div>

  
<div class="card mt-3">
    <div class="card-header">
        <h4>Dentist Legal Representation</h4>
    </div>

    <div class="card-body">
        <form class="row g-4"
              action="{{ route('dentists-details.store') }}"
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
        <!-- ================= HEADING ================= -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">
                Heading <span class="text-danger">*</span>
            </label>
        
            <input type="text"
                   name="heading"
                   class="form-control"
                   placeholder="Enter Heading"
                   value="{{ old('heading') }}"
                   required>
        
            @error('heading')
                <small class="text-danger">{{ $message }}</small>
            @enderror
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
