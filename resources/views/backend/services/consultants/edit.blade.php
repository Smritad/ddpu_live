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
                    <h4>Edit Consultants Details Form</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('consultants-details.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Consultants Details</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- FORM CARD -->
        <div class="card mt-3">
            <div class="card-header">
                <h4>Consultants</h4>
            </div>

            <div class="card-body">
                <form class="row g-4"
      action="{{ route('consultants-details.update', $ConsultantsDetails->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

                    <div class="col-md-12">
    <label class="form-label fw-semibold">
        Banner Image <span class="text-danger">*</span>
    </label>

    <input type="file"
           class="form-control"
           name="banner_image"
           accept=".jpg,.jpeg,.png,.webp"
           onchange="previewImage(this, 'bannerPreview', 'bannerSize', 'removeBannerBtn')">

    <div class="position-relative d-inline-block mt-2">
        <img id="bannerPreview"
             src="{{ asset('consultants/banner/'.$ConsultantsDetails->banner_image) }}"
             width="150"
             style="border:1px solid #ddd; padding:5px; border-radius:6px;">

        <span id="removeBannerBtn"
              onclick="removeImage('banner_image','bannerPreview','bannerSize','removeBannerBtn')"
              class="remove-icon">
            ×
        </span>
    </div>

    <small id="bannerSize" class="text-muted d-block"></small>
</div>

<!-- Heading -->
<div class="col-md-12">
    <label class="form-label fw-semibold">Heading <span class="text-danger">*</span></label>
    <input type="text" name="heading" class="form-control"
           placeholder="Heading"
           value="{{ $ConsultantsDetails->heading }}" required>
</div>

<!-- Consultant Details Table -->
<div class="col-md-12 mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Services Available</h5>
            <button type="button" class="btn btn-primary btn-sm" id="addDetail">+ Add More</button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="consultantTable">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 30%;">Title</th>
        <th style="width: 55%;">Description</th>
        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ConsultantsDetails->details as $detail)
                        <tr class="detailRow">
                            <td>
                                <input type="text" name="title[]" class="form-control"
                                       placeholder="Title" value="{{ $detail['title'] }}" required>
                            </td>
                            <td>
                                <textarea name="description[]" class="form-control editor"
                                          placeholder="Description" required>{{ $detail['description'] ?? '' }}</textarea>
                            </td>

                            <td class="text-center">
                                <button type="button" class="btn btn-danger removeDetail">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($ConsultantsDetails->details) == 0)
                        <tr class="detailRow">
                            <td><input type="text" name="title[]" class="form-control" placeholder="Title" required></td>
                            <td>
                                <textarea name="description[]" class="form-control editor"
                                          placeholder="Description">{{ $detail['description'] ?? '' }}</textarea>
                            </td>
                            <td class="text-center"><button type="button" class="btn btn-danger removeDetail">Remove</button></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


                    <!-- ================= SUBMIT ================= -->
                    <div class="col-12 text-end">
                        <button class="btn btn-primary px-4" type="submit">Update</button>
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


    let editors = [];

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#consultantTable tbody');
    const addBtn = document.getElementById('addDetail');

    // Initialize existing textareas
    tableBody.querySelectorAll('textarea.editor').forEach(el => {
        ClassicEditor.create(el)
            .then(editor => editors.push(editor))
            .catch(error => console.error(error));
    });

    // Add new row
    addBtn.addEventListener('click', function () {
        const newRow = document.createElement('tr');
        newRow.classList.add('detailRow');
        newRow.innerHTML = `
            <td><input type="text" name="title[]" class="form-control" placeholder="Title"></td>
            <td><textarea name="description[]" class="form-control editor" placeholder="Description"></textarea></td>
            <td class="text-center"><button type="button" class="btn btn-danger removeDetail">Remove</button></td>
        `;
        tableBody.appendChild(newRow);

        const newTextarea = newRow.querySelector('textarea.editor');
        ClassicEditor.create(newTextarea)
            .then(editor => editors.push(editor))
            .catch(error => console.error(error));
    });

    // Form submit validation
    document.querySelector('form').addEventListener('submit', function(e) {
        let valid = true;
        editors.forEach(editor => {
            if (!editor.getData().trim()) valid = false;
        });
        if (!valid) {
            e.preventDefault();
            alert("Please fill all description fields.");
        }
    });

    // Remove row
    tableBody.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('removeDetail')) {
            e.target.closest('tr').remove();
        }
    });
});


</script>

</body>
</html>


