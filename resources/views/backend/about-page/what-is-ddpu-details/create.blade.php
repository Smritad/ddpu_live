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
                <h4>Add DDPU Details Form</h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('what-is-ddpu-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add DDPU Details</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- CARD -->
    <div class="card mt-3">
        <div class="card-header">
            <h4>DDPU Details Form</h4>
            <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
        </div>

        <div class="card-body">
            <form class="row g-4 needs-validation custom-input"
                  novalidate
                  action="{{ route('what-is-ddpu-details.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <!-- ================= BANNER IMAGE ================= -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Banner Image <span class="txt-danger">*</span>
                    </label>

                    <input type="file"
                           class="form-control"
                           name="banner_image"
                           accept=".jpg,.jpeg,.png,.webp,.svg"
                           required
                           onchange="previewSingleImage(this)">

                    <small class="text-muted d-block mt-1">
                        Allowed: JPG, JPEG, PNG, WEBP, SVG | Max size: ~10MB
                    </small>
                </div>

                <!-- ================= BANNER PREVIEW ================= -->
                <div class="col-md-6" id="bannerPreviewBox" style="display:none;">
                    <label class="form-label fw-semibold">Preview</label>
                    <div class="position-relative d-inline-block">
                        <span class="remove-img" onclick="removeBannerImage()">×</span>
                        <img id="banner_preview"
                             class="img-fluid"
                             style="max-height:200px;border:1px solid #ddd;padding:5px;">
                    </div>
                </div>

                <!-- ================= TITLE ================= -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Title <span class="txt-danger">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           placeholder="Enter title *"
                           required>
                </div>

                <!-- ================= GALLERY ================= -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Gallery Images</label>

                    <input type="file"
                           class="form-control"
                           name="gallery_images[]"
                           multiple
                           accept=".jpg,.jpeg,.png,.webp,.svg"
                           onchange="previewMultipleImages(this)">

                    <small class="text-muted d-block mt-1">
                        You can upload multiple images (Max size: ~10MB each)
                    </small>
                </div>

                <!-- ================= GALLERY PREVIEW ================= -->
                <div class="col-md-12 d-flex flex-wrap gap-2" id="multiPreview"></div>

                <!-- ================= PROFESSIONAL DESCRIPTION ================= -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">
                        Professional Description <span class="txt-danger">*</span>
                    </label>
                    <textarea name="professional_description"
                              id="editor1"
                              class="form-control"
                              placeholder="Enter professional description *"
                              required></textarea>
                </div>

                <!-- ================= COMPARISON DESCRIPTION ================= -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">
                        How Others Compare With Us <span class="txt-danger">*</span>
                    </label>
                    <textarea name="compare_description"
                              id="editor"
                              class="form-control"
                              placeholder="Enter comparison description *"
                              required></textarea>
                </div>

                <!-- ================= SUBMIT ================= -->
                <div class="col-12 text-end mt-3">
                    <a href="{{ route('what-is-ddpu-details.index') }}"
                       class="btn btn-danger px-4">Cancel</a>

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
/* ==========================
   SINGLE BANNER PREVIEW
========================== */
function previewSingleImage(input) {
    const previewBox = document.getElementById('bannerPreviewBox');
    const preview = document.getElementById('banner_preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            previewBox.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeBannerImage() {
    document.querySelector('input[name="banner_image"]').value = '';
    document.getElementById('bannerPreviewBox').style.display = 'none';
}

/* ==========================
   MULTIPLE GALLERY PREVIEW
========================== */
function previewMultipleImages(input) {
    const preview = document.getElementById('multiPreview');
    preview.innerHTML = '';

    Array.from(input.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'position-relative';
            div.innerHTML = `
                <span class="remove-img" onclick="removeMultiImage(${index})">×</span>
                <img src="${e.target.result}"
                     style="max-height:150px;border:1px solid #ddd;padding:5px;">
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function removeMultiImage(index) {
    const input = document.querySelector('input[name="gallery_images[]"]');
    const dt = new DataTransfer();

    Array.from(input.files).forEach((file, i) => {
        if (i !== index) dt.items.add(file);
    });

    input.files = dt.files;
    previewMultipleImages(input);
}
</script>

</body>
</html>
