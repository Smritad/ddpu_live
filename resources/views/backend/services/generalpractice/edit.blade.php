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
.mt-2 {
    margin-top: 0.5rem !important;
    background-color: black;
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
                <h4>Edit Dentists Details Form</h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('general-practice-details.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Edit General Practice Details</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-3">
        <div class="card-header bg-white">
            <h4 class="mb-0">Edit General Practice</h4>
        </div>

        <div class="card-body">
            <form class="row g-4"
                  action="{{ route('general-practice-details.update', $generalpractice->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ================= BANNER IMAGE ================= -->
            <div class="col-md-12">
                <label class="form-label fw-semibold">Banner Image</label>
                <input type="file"
                       class="form-control"
                       name="banner_image"
                       accept=".jpg,.jpeg,.png,.webp"
                       onchange="previewImage(this, 'bannerPreview', 'removeBanner')">

                <div class="position-relative d-inline-block mt-2">
                    <img id="bannerPreview"
                         src="{{ asset('generalpractice/banner/'.$generalpractice->banner_image) }}"
                         width="180"
                         class="img-thumbnail">
                    <span class="remove-icon" id="removeBanner"
                          onclick="removeImage('banner_image','bannerPreview','removeBanner')">×</span>
                </div>
            </div>

            <!-- ================= MAIN IMAGE ================= -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Main Image</label>
                <input type="file"
                       class="form-control"
                       name="main_image"
                       accept=".jpg,.jpeg,.png,.webp"
                       onchange="previewImage(this, 'mainPreview', 'removeMain')">

                <div class="mt-2 position-relative d-inline-block">
                    <img id="mainPreview"
                         src="{{ asset('generalpractice/main/'.$generalpractice->main_image) }}"
                         width="150"
                         class="img-thumbnail">
                    <span class="remove-icon" id="removeMain"
                          onclick="removeImage('main_image','mainPreview','removeMain')">×</span>
                </div>
            </div>

            <!-- ================= DESCRIPTION ================= -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                <textarea name="description"
                          id="editor"
                          class="form-control"
                          rows="6"
                          required>{{ $generalpractice->description }}</textarea>
            </div>

            <!-- ================= PRACTICE FEATURES ================= -->
            <div class="col-md-12 mt-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Practice Features</h5>
                        <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">+ Add More</button>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0" id="itemsTable">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th width="180">Icon</th>
                                        <th width="200">Heading</th>
                                        <th>Description</th>
                                        <th width="80">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="text-center">
                                    @foreach($generalpractice->items as $key => $item)
                                    <tr>
                                        <td>
                                            <input type="hidden"
                                                   name="items[{{ $key }}][old_icon]"
                                                   value="{{ $item['icon'] }}">
                                            <input type="file"
                                                   name="items[{{ $key }}][icon]"
                                                   class="form-control form-control-sm"
                                                   accept=".jpg,.jpeg,.png,.webp"
                                                   onchange="previewImage(this, 'itemPreview{{ $key }}', 'removeItem{{ $key }}')">
                                            <div class="mt-2 position-relative d-inline-block">
                                                <img src="{{ asset('generalpractice/icons/'.$item['icon']) }}"
                                                     width="60"
                                                     class="img-thumbnail"
                                                     id="itemPreview{{ $key }}">
                                                <span class="remove-icon"
                                                      id="removeItem{{ $key }}"
                                                      onclick="removeImage('items[{{ $key }}][icon]','itemPreview{{ $key }}','removeItem{{ $key }}')">×</span>
                                            </div>
                                        </td>

                                        <td>
                                            <input type="text"
                                                   name="items[{{ $key }}][heading]"
                                                   value="{{ $item['heading'] }}"
                                                   class="form-control form-control-sm"
                                                   required>
                                        </td>

                                        <td>
                                            <textarea name="items[{{ $key }}][description]"
                                                      class="form-control form-control-sm"
                                                      rows="2"
                                                      required>{{ $item['description'] }}</textarea>
                                        </td>

                                        <td>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="removeRow(this)">X</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ================= BENEFITS ================= -->
            <div class="col-md-12 mt-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Benefits</h5>
                    </div>
            
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Heading <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="benefits_heading"
                                       value="{{ $generalpractice->benefits_heading ?? '' }}"
                                       class="form-control"
                                       required>
                            </div>
            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                                <textarea name="benefits_description" id="editor1" rows="4">{{ $generalpractice->benefits_description ?? '' }}</textarea>
            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= SUBMIT ================= -->
            <div class="col-12 text-end">
        <a href="{{ route('general-practice-details.index') }}" class="btn btn-danger px-4">Cancel</a>
                <button class="btn btn-success px-4" type="submit">Update</button>
            </div>

            </form>
        </div>
    </div>

</div>
</div>



@include('components.backend.footer')
@include('components.backend.main-js')

<script>
let rowCount = {{ count($generalpractice->items) }};

// Show preview and X icon for new file uploads
function previewImage(input, previewId, removeId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const removeIcon = document.getElementById(removeId);

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
            removeIcon.style.display = "flex";
        }
        reader.readAsDataURL(file);
    }
}

// Remove image preview and clear file input
function removeImage(inputName, previewId, removeId) {
    const input = document.querySelector(`input[name='${inputName}']`);
    const preview = document.getElementById(previewId);
    const removeIcon = document.getElementById(removeId);

    input.value = "";
    preview.src = "";
    preview.style.display = "none";
    removeIcon.style.display = "none";
}

// Add new row dynamically
function addRow() {
    let row = `
    <tr>
        <td>
            <input type="file"
                   name="items[${rowCount}][icon]"
                   class="form-control form-control-sm"
                   accept=".jpg,.jpeg,.png,.webp"
                   onchange="previewImage(this, 'itemPreview${rowCount}', 'removeItem${rowCount}')"
                   required>
            <div class="mt-2 position-relative d-inline-block">
                <img id="itemPreview${rowCount}" width="60" class="img-thumbnail">
                <span class="remove-icon" id="removeItem${rowCount}"
                      onclick="removeImage('items[${rowCount}][icon]','itemPreview${rowCount}','removeItem${rowCount}')">×</span>
            </div>
        </td>

        <td>
            <input type="text"
                   name="items[${rowCount}][heading]"
                   class="form-control form-control-sm"
                   required>
        </td>

        <td>
            <textarea name="items[${rowCount}][description]"
                      class="form-control form-control-sm"
                      rows="2"
                      required></textarea>
        </td>

        <td>
            <button type="button"
                    class="btn btn-sm btn-outline-danger"
                    onclick="removeRow(this)">X</button>
        </td>
    </tr>`;
    document.querySelector('#itemsTable tbody').insertAdjacentHTML('beforeend', row);
    rowCount++;
}

// Remove a row
function removeRow(btn) {
    btn.closest('tr').remove();
}
</script>

</body>
</html>
