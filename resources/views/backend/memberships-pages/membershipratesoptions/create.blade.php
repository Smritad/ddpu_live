<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
</head>

<body>

@include('components.backend.header')
@include('components.backend.sidebar')

<style>
.remove-icon-btn {
    display: none;
    position: absolute;
    top: -8px;
    right: -8px;
    background: #dc3545;
    color: #fff;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    text-align: center;
    line-height: 22px;
    cursor: pointer;
    font-weight: bold;
}
</style>

<div class="page-body">
<div class="container-fluid">

    <!-- PAGE TITLE -->
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Add Memberships Rate Option Details</h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('membership-rates-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Memberships Rate Option</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- CARD -->
    <div class="card mt-3">
        <div class="card-header">
            <h4>Memberships Rate Option</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('membership-rates-details.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- ================= BANNER ================= -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Banner Image *</label>

                    <input type="file" name="banner_image" class="form-control"
                           accept=".jpg,.jpeg,.png,.webp"
                           onchange="previewBanner(this)" required>

                    <div class="position-relative d-inline-block mt-2">
                        <img id="bannerPreview" width="200"
                             style="display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">

                        <span id="removeBanner" class="remove-icon-btn"
                              onclick="removeBannerImage()">×</span>
                    </div>

                    <small id="bannerSize" class="text-muted d-block"></small>
                </div>


 <!-- ================= MAIN HEADING ================= -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Subscription Heading <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="subscription_heading"
                       class="form-control"
                       placeholder="Enter Subscription Heading"
                       required>
            </div>

            <!-- ================= MAIN DESCRIPTION ================= -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Subscription Description <span class="text-danger">*</span>
                </label>

                <textarea name="subscription_description"
                          class="form-control"
                          rows="3"
                          placeholder="Enter short description"
                          required></textarea>
            </div>
                <!-- ================= OPTIONS ================= -->
                <div id="optionsWrapper">

                    <!-- ===== DEFAULT OPTION ===== -->
                    <div class="option-item border rounded p-3 mb-3">

                        <div class="d-flex justify-content-between">
                            <h5>Subscription Option</h5>
                            <button type="button" class="btn btn-danger btn-sm removeOption">Remove</button>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label>Title</label>
                                <input type="text" name="options[0][title]" class="form-control" placeholder="Option 1">
                            </div>

                            <div class="col-md-6">
                                <label>Heading</label>
                                <input type="text" name="options[0][heading]" class="form-control" placeholder="Twelve Monthly Instalments">
                            </div>
                        </div>

                        <div class="mt-2">
                            <label>Description (Amount List)</label>
                            <textarea name="options[0][description]" class="form-control editor1" rows="6"></textarea>
                        </div>

                    </div>

                </div>

                <!-- ADD OPTION -->
                <button type="button" id="addOption" class="btn btn-success mb-3">
                    + Add Subscription Option
                </button>

                <!-- SUBMIT -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>

            </form>
        </div>
    </div>

</div>
</div>

@include('components.backend.footer')
@include('components.backend.main-js')

<!-- ================= CKEDITOR ================= -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
function initEditor() {
    document.querySelectorAll('.editor1').forEach(function(el){
        if (!el.classList.contains('ck-initialized')) {
            ClassicEditor.create(el).catch(error => console.error(error));
            el.classList.add('ck-initialized');
        }
    });
}

document.addEventListener("DOMContentLoaded", function(){
    initEditor();
});
</script>

<!-- ================= DYNAMIC OPTION ================= -->
<script>
let optionIndex = 1;

document.getElementById('addOption').addEventListener('click', function () {

    let wrapper = document.getElementById('optionsWrapper');

    let html = `
    <div class="option-item border rounded p-3 mb-3">

        <div class="d-flex justify-content-between">
            <h5>Subscription Option</h5>
            <button type="button" class="btn btn-danger btn-sm removeOption">Remove</button>
        </div>

        <div class="row mt-2">
            <div class="col-md-6">
                <input type="text" name="options[${optionIndex}][title]" class="form-control" placeholder="Option Title">
            </div>

            <div class="col-md-6">
                <input type="text" name="options[${optionIndex}][heading]" class="form-control" placeholder="Heading">
            </div>
        </div>

        <div class="mt-2">
            <textarea name="options[${optionIndex}][description]" class="form-control editor1" rows="6"></textarea>
        </div>

    </div>`;

    wrapper.insertAdjacentHTML('beforeend', html);

    initEditor();
    optionIndex++;
});

// remove option
document.addEventListener('click', function(e){
    if(e.target.classList.contains('removeOption')){
        e.target.closest('.option-item').remove();
    }
});
</script>

<!-- ================= IMAGE PREVIEW ================= -->
<script>
function previewBanner(input) {
    let file = input.files[0];

    if (file) {
        let reader = new FileReader();

        reader.onload = function(e) {
            let img = document.getElementById('bannerPreview');
            img.src = e.target.result;
            img.style.display = 'block';

            document.getElementById('removeBanner').style.display = 'block';

            let size = (file.size / 1024).toFixed(2);
            document.getElementById('bannerSize').innerText = "File size: " + size + " KB";
        }

        reader.readAsDataURL(file);
    }
}

function removeBannerImage() {
    let input = document.querySelector('input[name="banner_image"]');
    input.value = '';

    document.getElementById('bannerPreview').style.display = 'none';
    document.getElementById('removeBanner').style.display = 'none';
    document.getElementById('bannerSize').innerText = '';
}
</script>

</body>
</html>
