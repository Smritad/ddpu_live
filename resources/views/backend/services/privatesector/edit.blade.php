<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
   <style>
    .remove-icon {
        display: flex; /* show by default for existing images */
        justify-content: center;
        align-items: center;
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: #fff;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        line-height: 22px;
        text-align: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .remove-icon:hover {
        background: #b02a37;
    }

    .position-relative img {
        display: block;
    }
    </style>
</head>

<body>
@include('components.backend.header')
@include('components.backend.sidebar')

<div class="page-body">
    <div class="container-fluid">

        <!-- PAGE TITLE -->
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Edit Private Sector Details Form</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('private-sectoracademic-details.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Private Sector Detail</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- FORM CARD -->
        <div class="card mt-3">
            <div class="card-header">
                <h4>Private Sector Detail</h4>
            </div>

            <div class="card-body">
               
                  <form class="row g-4"
      action="{{ route('private-sectoracademic-details.update', $privatesector->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- ================= BANNER IMAGE ================= -->
    <div class="col-md-12">
        <label class="form-label fw-semibold">
            Banner Image
        </label>

        <input type="file"
               class="form-control"
               name="banner_image"
               accept=".jpg,.jpeg,.png,.webp"
               onchange="previewImage(this, 'bannerPreview', 'bannerSize', 'removeBannerBtn')">

        <div class="position-relative d-inline-block mt-2">

            @if($privatesector->banner_image)
                <img id="bannerPreview"
                     src="{{ asset('PrivateSectorDetails/banner/'.$privatesector->banner_image) }}"
                     width="150"
                     style="border:1px solid #ddd; padding:5px; border-radius:6px;">

                <span id="removeBannerBtn"
                      onclick="removeExistingImage('banner_image','bannerPreview','removeBannerBtn')"
                      style="cursor:pointer; position:absolute; top:-8px; right:-8px;
                             background:#dc3545; color:#fff; border-radius:50%;
                             width:22px; height:22px; text-align:center;">
                    ×
                </span>
            @else
                <img id="bannerPreview" width="150" style="display:none;">
                <span id="removeBannerBtn" style="display:none;"></span>
            @endif

        </div>

        <small id="bannerSize" class="text-muted d-block"></small>
    </div>

    <!-- ================= MAIN IMAGE ================= -->
    <div class="col-md-12">
        <label class="form-label fw-semibold">
            Private Main Image
        </label>

        <input type="file"
               class="form-control"
               name="main_image"
               accept=".jpg,.jpeg,.png,.webp"
               onchange="previewImage(this, 'mainPreview', 'mainSize', 'removeMainBtn')">

        <div class="position-relative d-inline-block mt-2">

            @if($privatesector->main_image)
                <img id="mainPreview"
                     src="{{ asset('PrivateSectorDetails/main/'.$privatesector->main_image) }}"
                     width="150"
                     style="border:1px solid #ddd; padding:5px; border-radius:6px;">

                <span id="removeMainBtn"
                      onclick="removeExistingImage('main_image','mainPreview','removeMainBtn')"
                      style="cursor:pointer; position:absolute; top:-8px; right:-8px;
                             background:#dc3545; color:#fff; border-radius:50%;
                             width:22px; height:22px; text-align:center;">
                    ×
                </span>
            @else
                <img id="mainPreview" width="150" style="display:none;">
                <span id="removeMainBtn" style="display:none;"></span>
            @endif

        </div>

        <small id="mainSize" class="text-muted d-block"></small>
    </div>

    <!-- ================= HEADING ================= -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Private Heading</label>
        <input type="text" name="heading"
               value="{{ $privatesector->heading }}"
               class="form-control" required>
    </div>

    <!-- ================= DESCRIPTION ================= -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Private Description</label>
        <textarea name="description" id="editor" class="form-control" rows="6">
            {{ $privatesector->description }}
        </textarea>
    </div>

    <!-- ================= Academic HEADING ================= -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Academic Heading</label>
        <input type="text"
               name="Acdemic_heading"
               value="{{ $privatesector->academic_heading }}"
               class="form-control" required>
    </div>

    <!-- ================= Academic DESCRIPTION ================= -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Academic Description</label>
        <textarea name="Acdemic_description" id="editor1" class="form-control" rows="6">
            {{ $privatesector->academic_description }}
        </textarea>
    </div>

    <!-- ================= BUTTONS ================= -->
    <div class="col-12 text-end">

        <a href="{{ route('private-sectoracademic-details.index') }}"
           class="btn btn-secondary px-4 me-2">
            Cancel
        </a>

        <button class="btn btn-primary px-4" type="submit">
            Update
        </button>
    </div>

</form>

            </div>
        </div>

    </div>
</div>

@include('components.backend.footer')
@include('components.backend.main-js')

<!-- ================= JS ================= -->
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

        const sizeKB = (file.size / 1024).toFixed(2);
        sizeText.innerHTML = "File Size: " + sizeKB + " KB";
    }
}

// remove newly selected file
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

// remove existing image
function removeExistingImage(inputName, previewId, removeBtnId) {
    document.getElementById(previewId).style.display = 'none';
    document.getElementById(removeBtnId).style.display = 'none';

    let hidden = document.createElement("input");
    hidden.type = "hidden";
    hidden.name = "remove_" + inputName;
    hidden.value = "1";

    document.querySelector("form").appendChild(hidden);
}
</script>

</body>
</html>


