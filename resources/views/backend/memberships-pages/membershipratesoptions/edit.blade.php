<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
    <style>
        .remove-icon {
            display: flex;
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
        .remove-icon:hover { background: #b02a37; }
        .position-relative img { display: block; }
    </style>
</head>
<body>
@include('components.backend.header')
@include('components.backend.sidebar')

<div class="page-body">
<div class="container-fluid">

    <!-- PAGE TITLE -->
    <div class="page-title mb-3">
        <div class="row">
            <div class="col-6"><h4>Edit Memberships Rate Option Form</h4></div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('membership-rates-details.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Memberships Rate Option Details</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0">Edit Memberships Rate Option</h4>
        </div>

        <div class="card-body">
            <form class="row g-4"
                  action="{{ route('membership-rates-details.update', $memberships->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- BANNER -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Banner Image</label>
                <input type="file" name="banner_image" class="form-control" accept=".jpg,.jpeg,.png,.webp" onchange="previewBanner(this)">
                <div class="position-relative d-inline-block mt-2">
                    @if($memberships->banner_image && file_exists(public_path('memberships/banner/'.$memberships->banner_image)))
                        <img id="bannerPreview" src="{{ asset('memberships/banner/'.$memberships->banner_image) }}" width="200" style="border:1px solid #ddd; padding:5px; border-radius:6px;">
                        <span id="removeBanner" class="remove-icon" onclick="removeBannerImage()">×</span>
                    @else
                        <img id="bannerPreview" width="200" style="display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">
                        <span id="removeBanner" class="remove-icon" style="display:none;" onclick="removeBannerImage()">×</span>
                    @endif
                </div>
                <small id="bannerSize" class="text-muted d-block"></small>
            </div>

            <!-- SUBSCRIPTION HEADING -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Subscription Heading <span class="text-danger">*</span></label>
                <input type="text" name="subscription_heading" class="form-control"
                       value="{{ old('subscription_heading', $memberships->subscription_heading) }}"
                       placeholder="Enter Subscription Heading" required>
            </div>

            <!-- SUBSCRIPTION DESCRIPTION -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Subscription Description <span class="text-danger">*</span></label>
                <textarea name="subscription_description" class="form-control" rows="3" required
                          placeholder="Enter short description">{{ old('subscription_description', $memberships->subscription_description) }}</textarea>
            </div>

            <!-- SUBSCRIPTION OPTIONS -->
            <div id="optionsWrapper">
                @php $options = json_decode($memberships->options, true) ?? []; @endphp

                @foreach($options as $index => $option)
                    <div class="option-item border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <h5>Subscription Option</h5>
                            <button type="button" class="btn btn-danger btn-sm removeOption">Remove</button>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <input type="text" name="options[{{ $index }}][title]" class="form-control" placeholder="Option Title" value="{{ $option['title'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="options[{{ $index }}][heading]" class="form-control" placeholder="Heading" value="{{ $option['heading'] ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2">
                            <textarea name="options[{{ $index }}][description]" class="form-control editor1" rows="6">{!! $option['description'] !!}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" id="addOption" class="btn btn-success mb-3">+ Add Subscription Option</button>

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

<script>
let optionIndex = {{ count($options) ?? 0 }};

/* CKEDITOR INIT */
function initEditor() {
    document.querySelectorAll('.editor1').forEach(el => {
        if (!el.classList.contains('ck-initialized')) {
            ClassicEditor.create(el).catch(error => console.error(error));
            el.classList.add('ck-initialized');
        }
    });
}
document.addEventListener("DOMContentLoaded", initEditor);

/* ADD NEW OPTION */
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

/* REMOVE OPTION */
document.addEventListener('click', function(e){
    if(e.target.classList.contains('removeOption')){
        let optionDiv = e.target.closest('.option-item');
        let textarea = optionDiv.querySelector('textarea');
        if(textarea && textarea.name.match(/\d+/)) {
            let index = textarea.name.match(/\d+/)[0];
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'options_to_delete[]';
            input.value = index;
            document.querySelector('form').appendChild(input);
        }
        optionDiv.remove();
    }
});

/* BANNER PREVIEW */
function previewBanner(input) {
    let file = input.files[0];
    if(file){
        let reader = new FileReader();
        reader.onload = function(e){
            let img = document.getElementById('bannerPreview');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('removeBanner').style.display = 'block';
            document.getElementById('bannerSize').innerText = "File size: " + (file.size/1024).toFixed(2) + " KB";

            let delInput = document.querySelector('input[name="banner_delete"]');
            if(delInput) delInput.remove();
        }
        reader.readAsDataURL(file);
    }
}

/* REMOVE BANNER */
function removeBannerImage() {
    document.querySelector('input[name="banner_image"]').value = '';
    document.getElementById('bannerPreview').style.display = 'none';
    document.getElementById('removeBanner').style.display = 'none';
    document.getElementById('bannerSize').innerText = '';

    if(!document.querySelector('input[name="banner_delete"]')) {
        let delInput = document.createElement('input');
        delInput.type = 'hidden';
        delInput.name = 'banner_delete';
        delInput.value = 1;
        document.querySelector('form').appendChild(delInput);
    }
}
</script>

</body>
</html>
