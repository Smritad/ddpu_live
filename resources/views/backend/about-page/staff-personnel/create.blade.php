<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')

    <style>
        .preview-box {
            position: relative;
            display: inline-block;
            margin-top: 10px;
        }
        .preview-box img {
            max-height: 200px;
            border: 1px solid #ddd;
            padding: 5px;
        }
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
</head>

<body>
@include('components.backend.header')
@include('components.backend.sidebar')

<div class="page-body">
<div class="container-fluid">

<div class="page-title">
    <div class="row">
        <div class="col-6"><h4>Add Staff Personnel Details</h4></div>
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('staff-personnel.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Add Staff Personnel</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header">
    <h4>Staff Personnel Form</h4>
    <p class="f-m-light mt-1">Please fill all required details and submit the form.</p>
</div>

<div class="card-body">
<form class="row g-3 needs-validation"
      novalidate
      action="{{ route('staff-personnel.store') }}"
      method="POST"
      enctype="multipart/form-data">
@csrf

<!-- Banner Image -->
<div class="col-md-6">
    <label class="form-label fw-semibold">Banner Image <span class="txt-danger">*</span></label>
    <input class="form-control"
           type="file"
           name="banner_image"
           required
           accept=".jpg,.jpeg,.png,.webp,.svg"
           placeholder="Upload banner image"
           onchange="previewBannerImage(this)">
    <small class="text-muted">Recommended size: 1200x500px</small>

    <div id="bannerImagePreviewContainer" style="display:none;">
        <div class="preview-box">
            <span class="remove-img" onclick="removeBannerPreview()">×</span>
            <img id="banner_image_preview">
        </div>
    </div>
</div>

<!-- Profile Image -->
<div class="col-md-6">
    <label class="form-label fw-semibold">Profile Image <span class="txt-danger">*</span></label>
    <input class="form-control"
           type="file"
           name="profile_image"
           required
           accept=".jpg,.jpeg,.png,.webp,.svg"
           placeholder="Upload profile photo"
           onchange="previewProfileImage(this)">
    <small class="text-muted">Recommended size: 400x400px</small>

    <div id="profileImagePreviewContainer" style="display:none;">
        <div class="preview-box">
            <span class="remove-img" onclick="removeProfilePreview()">×</span>
            <img id="profile_image_preview">
        </div>
    </div>
</div>

<!-- Name -->
<div class="col-md-4">
    <label class="form-label fw-semibold">Full Name <span class="txt-danger">*</span></label>
    <input type="text"
           name="name"
           class="form-control"
           placeholder="Enter full name"
           required>
</div>

<!-- Designation -->
<div class="col-md-4">
    <label class="form-label fw-semibold">Designation <span class="txt-danger"><span class="txt-danger">*</span></span></label>
    <input type="text"
           name="designation"
           class="form-control"
           placeholder="Enter designation"
           required>
</div>

<!-- Title -->
<div class="col-md-4">
    <label class="form-label fw-semibold">Title</label>
    <input type="text"
           name="title"
           class="form-control"
           placeholder="Enter title (optional)">
</div>

<!-- Description -->
<div class="col-md-12">
    <label class="form-label fw-semibold">Description</label>
    <textarea name="description" id="editor"
              class="form-control"
              rows="4"
              placeholder="Write short description about staff member"></textarea>
</div>

<!-- Social Links -->
<div class="col-md-12">
    <label class="form-label fw-semibold">Social Links</label>

    <div id="socialLinksContainer">
        <div class="row g-2 mb-2 social-link-row">
            <div class="col-md-3">
                <input type="text"
                       name="social_name[]"
                       class="form-control"
                       placeholder="Social Name">
            </div>
            <div class="col-md-4">
                <input type="url"
                       name="social_link[]"
                       class="form-control"
                       placeholder="https://example.com/profile">
            </div>
            <div class="col-md-2">
                <button type="button"
                        class="btn btn-danger w-100"
                        onclick="removeSocialLink(this)">×</button>
            </div>
        </div>
    </div>

    <button type="button"
            class="btn btn-primary btn-sm mt-2"
            onclick="addSocialLink()">+ Add Social Link</button>
</div>

<!-- Submit -->
<div class="col-12 text-end mt-3">
    <a href="{{ route('staff-personnel.index') }}" class="btn btn-danger px-4">Cancel</a>
    <button class="btn btn-primary px-4">Submit</button>
</div>

</form>
</div>
</div>
</div>
</div>

</div>
</div>

@include('components.backend.footer')
@include('components.backend.main-js')

<script>
function previewBannerImage(input) {
    const box = document.getElementById('bannerImagePreviewContainer');
    const img = document.getElementById('banner_image_preview');
    if (input.files[0]) {
        const r = new FileReader();
        r.onload = e => { img.src = e.target.result; box.style.display = 'block'; };
        r.readAsDataURL(input.files[0]);
    }
}

function removeBannerPreview() {
    document.querySelector('input[name="banner_image"]').value = '';
    document.getElementById('bannerImagePreviewContainer').style.display = 'none';
}

function previewProfileImage(input) {
    const box = document.getElementById('profileImagePreviewContainer');
    const img = document.getElementById('profile_image_preview');
    if (input.files[0]) {
        const r = new FileReader();
        r.onload = e => { img.src = e.target.result; box.style.display = 'block'; };
        r.readAsDataURL(input.files[0]);
    }
}

function removeProfilePreview() {
    document.querySelector('input[name="profile_image"]').value = '';
    document.getElementById('profileImagePreviewContainer').style.display = 'none';
}

function addSocialLink() {
    const container = document.getElementById('socialLinksContainer');
    container.insertAdjacentHTML('beforeend', `
        <div class="row g-2 mb-2 social-link-row">
            <div class="col-md-3">
                <input type="text" name="social_name[]" class="form-control" placeholder="Social name">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_link[]" class="form-control" placeholder="https://example.com">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger w-100" onclick="removeSocialLink(this)">×</button>
            </div>
        </div>
    `);
}

function removeSocialLink(btn) {
    btn.closest('.social-link-row').remove();
}
</script>

</body>
</html>
