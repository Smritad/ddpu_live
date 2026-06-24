<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')

<style>
.preview-box {
    position: relative;
    display: block;
    margin-top: 10px;
    width: 220px;
}

.preview-box img {
    width: 100%;
    max-height: 200px;
    object-fit: cover;
    border: 1px solid #ddd;
    padding: 5px;
    border-radius: 6px;
}

.remove-img {
    position: absolute;
    top: 5px;
    right: 5px;
    background: red;
    color: #fff;
    font-size: 16px;
    width: 24px;
    height: 24px;
    text-align: center;
    border-radius: 50%;
    cursor: pointer;
    line-height: 24px;
    font-weight: bold;
    z-index: 5;
}
</style></head>

<body>
@include('components.backend.header')
@include('components.backend.sidebar')

<div class="page-body">
<div class="container-fluid">

<div class="page-title">
    <div class="row">
        <div class="col-6"><h4>Edit Staff Personnel Details</h4></div>
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('staff-personnel.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Edit Staff Personnel</li>
            </ol>
        </div>
    </div>
</div>

<div class="card">
<div class="card-header">
    <h4>Staff Personnel Form</h4>
</div>

<div class="card-body">
<form class="row g-3 needs-validation"
      novalidate
      action="{{ route('staff-personnel.update', $staff->id) }}"
      method="POST"
      enctype="multipart/form-data">
@csrf
@method('PUT')

<input type="hidden" name="remove_old_banner" id="remove_old_banner" value="0">
<input type="hidden" name="remove_old_profile" id="remove_old_profile" value="0">
<input type="hidden" name="slug" value="{{ $staff->slug }}">

<!-- ======================
   BANNER IMAGE
====================== -->
<div class="col-md-6">
    <label class="form-label fw-semibold">Banner Image<span class="txt-danger">*</span></label>
    <input class="form-control" type="file" name="banner_image" onchange="previewBannerImage(this)">

    @if($staff->banner_image)
    <div id="oldBannerBox" class="preview-box">
        <span class="remove-img" onclick="removeOldBanner()">×</span>
        <img src="{{ asset('uploads/staff-personnel/'.$staff->banner_image) }}">
    </div>
    @endif

    <div id="newBannerBox" style="display:none;" class="preview-box">
        <span class="remove-img" onclick="removeNewBanner()">×</span>
        <img id="banner_preview">
    </div>
</div>

<!-- ======================
   PROFILE IMAGE
====================== -->
<div class="col-md-6">
    <label class="form-label fw-semibold">Profile Image<span class="txt-danger">*</span></label>
    <input class="form-control" type="file" name="profile_image" onchange="previewProfileImage(this)">

    @if($staff->profile_image)
    <div id="oldProfileBox" class="preview-box">
        <span class="remove-img" onclick="removeOldProfile()">×</span>
        <img src="{{ asset('uploads/staff-personnel/'.$staff->profile_image) }}">
    </div>
    @endif

    <div id="newProfileBox" style="display:none;" class="preview-box">
        <span class="remove-img" onclick="removeNewProfile()">×</span>
        <img id="profile_preview">
    </div>
</div>

<!-- ======================
   NAME
====================== -->
<div class="col-md-4">
    <label class="form-label fw-semibold">Full Name <span class="txt-danger">*</span></label>
    <input type="text" name="name" class="form-control" value="{{ $staff->name }}" required>
</div>

<div class="col-md-4">
    <label class="form-label fw-semibold">Designation <span class="txt-danger">*</span></label>
    <input type="text" name="designation" class="form-control" value="{{ $staff->designation }}" required>
</div>

<div class="col-md-4">
    <label class="form-label fw-semibold">Title <span class="txt-danger">*</span></label>
    <input type="text" name="title" class="form-control" value="{{ $staff->title }}">
</div>

<div class="col-md-12">
    <label class="form-label fw-semibold">Description<span class="txt-danger">*</span></label>
    <textarea name="description" id="editor" class="form-control" rows="4">{!! $staff->description !!}</textarea>
</div>

<!-- ======================
   SOCIAL LINKS
====================== -->
<div class="col-md-12">
    <label class="form-label fw-semibold">Social Links</label>
    <div id="socialLinksContainer">
        @foreach($socialLinks as $link)
        <div class="row g-2 mb-2 social-link-row">
            <div class="col-md-3">
                <input type="text" name="social_name[]" class="form-control" value="{{ $link['name'] }}">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_link[]" class="form-control" value="{{ $link['link'] }}">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger w-100" onclick="removeSocialLink(this)">×</button>
            </div>
        </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-primary btn-sm" onclick="addSocialLink()">+ Add Social Link</button>
</div>

<div class="col-12 text-end">
    <a href="{{ route('staff-personnel.index') }}" class="btn btn-danger">Cancel</a>
    <button class="btn btn-primary">Update</button>
</div>

</form>
</div>
</div>

</div>
</div>

@include('components.backend.footer')
@include('components.backend.main-js')

<script>
/* =====================
   BANNER
===================== */
function previewBannerImage(input){
    const box = document.getElementById('newBannerBox');
    const img = document.getElementById('banner_preview');
    img.src = URL.createObjectURL(input.files[0]);
box.style.display = 'block';}

function removeOldBanner(){
    document.getElementById('oldBannerBox').remove();
    document.getElementById('remove_old_banner').value = 1;
}

function removeNewBanner(){
    document.querySelector('input[name="banner_image"]').value = '';
    document.getElementById('newBannerBox').style.display = 'none';
}

/* =====================
   PROFILE
===================== */
function previewProfileImage(input){
    const box = document.getElementById('newProfileBox');
    const img = document.getElementById('profile_preview');
    img.src = URL.createObjectURL(input.files[0]);
box.style.display = 'block';}

function removeOldProfile(){
    document.getElementById('oldProfileBox').remove();
    document.getElementById('remove_old_profile').value = 1;
}

function removeNewProfile(){
    document.querySelector('input[name="profile_image"]').value = '';
    document.getElementById('newProfileBox').style.display = 'none';
}

/* =====================
   SOCIAL LINKS
===================== */
function addSocialLink(){
    document.getElementById('socialLinksContainer').insertAdjacentHTML('beforeend', `
        <div class="row g-2 mb-2 social-link-row">
            <div class="col-md-3"><input type="text" name="social_name[]" class="form-control"></div>
            <div class="col-md-4"><input type="url" name="social_link[]" class="form-control"></div>
            <div class="col-md-2"><button type="button" class="btn btn-danger w-100" onclick="removeSocialLink(this)">×</button></div>
        </div>
    `);
}

function removeSocialLink(btn){
    btn.closest('.social-link-row').remove();
}
</script>

</body>
</html>
