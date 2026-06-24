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
            border-radius: 5px;
        }
        .remove-img {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: #fff;
            font-size: 18px;
            width: 28px;
            height: 28px;
            text-align: center;
            border-radius: 50%;
            cursor: pointer;
            line-height: 28px;
            font-weight: bold;
            z-index: 10;
        }
        .icon-preview {
            max-height: 60px;
            display: block;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        h5.section-title {
            margin-top: 30px;
            margin-bottom: 15px;
            font-weight: 600;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
    </style>
</head>

<body>
@include('components.backend.header')
@include('components.backend.sidebar')

<div class="page-body">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row mb-3">
            <div class="col-6"><h4>Add Our Method Details</h4></div>
            <div class="col-6 text-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('our-methods.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Add Our Method</li>
                </ol>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Our Method Form</h5>
                <p class="text-muted mb-0">Fill in all the required fields and submit the form.</p>
            </div>

            <div class="card-body">
                <form class="row g-3 needs-validation" novalidate
                      action="{{ route('our-methods.store') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <!-- Banner Section -->
                    <h5 class="section-title">Banner Section</h5>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Banner Image <span class="text-danger">*</span></label>
                        <input type="file" name="banner_image" class="form-control" accept="image/*" required onchange="previewBanner(this)">
                    </div>
                    <div class="col-md-12" id="bannerPreviewBox" style="display:none;">
                        <div class="preview-box">
                            <span class="remove-img" onclick="removeBanner()">×</span>
                            <img id="bannerPreview" class="img-fluid">
                        </div>
                    </div>

                    <!-- Strategic Section -->
                    <h5 class="section-title">Strategic Section</h5>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Strategic Title <span class="text-danger">*</span></label>
                        <input type="text" name="strategic_title" class="form-control" placeholder="Enter strategic title" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Strategic Image <span class="text-danger">*</span></label>
                        <input type="file" name="strategic_image" class="form-control" required onchange="previewStrategic(this)">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Strategic Description</label>
                        <textarea name="strategic_description" class="form-control" rows="3" placeholder="Enter strategic description"></textarea>
                    </div>
                    <div class="col-md-12" id="strategicPreviewBox" style="display:none;">
                        <div class="preview-box">
                            <span class="remove-img" onclick="removeStrategic()">×</span>
                            <img id="strategicPreview" class="img-fluid">
                        </div>
                    </div>

                    <!-- Strategic Elements Section -->
                    <h5 class="section-title">Strategic Elements</h5>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Strategic Elements Title <span class="text-danger">*</span></label>
                        <input type="text" name="strategic_elements_title" class="form-control" placeholder="Enter strategic elements title" required>
                    </div>

                    <div class="col-md-12 d-flex justify-content-end mb-2">
                        <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">+ Add More</button>
                    </div>

                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered align-middle" id="strategicTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Icon</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="file" name="elements[0][icon]" class="form-control" accept="image/*" onchange="previewIcon(this)">
                                        <img class="icon-preview" style="display:none;">
                                    </td>
                                    <td><input type="text" name="elements[0][title]" class="form-control" placeholder="Element Title"></td>
                                    <td><textarea name="elements[0][description]" class="form-control" rows="2" placeholder="Element Description"></textarea></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn btn-success px-4">Submit</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@include('components.backend.footer')
@include('components.backend.main-js')

<script>
let rowIndex = 1;

/* Banner Preview */
function previewBanner(input){
    const file = input.files[0];
    if(file){
        document.getElementById('bannerPreview').src = URL.createObjectURL(file);
        document.getElementById('bannerPreviewBox').style.display = 'block';
    }
}
function removeBanner(){
    document.querySelector('input[name="banner_image"]').value = '';
    document.getElementById('bannerPreviewBox').style.display = 'none';
}

/* Strategic Preview */
function previewStrategic(input){
    const file = input.files[0];
    if(file){
        document.getElementById('strategicPreview').src = URL.createObjectURL(file);
        document.getElementById('strategicPreviewBox').style.display = 'block';
    }
}
function removeStrategic(){
    document.querySelector('input[name="strategic_image"]').value = '';
    document.getElementById('strategicPreviewBox').style.display = 'none';
}

/* Strategic Elements */
function previewIcon(input){
    const img = input.nextElementSibling;
    img.src = URL.createObjectURL(input.files[0]);
    img.style.display = 'block';
}

function addRow(){
    const table = document.querySelector('#strategicTable tbody');
    const row = `
    <tr>
        <td>
            <input type="file" name="elements[${rowIndex}][icon]" class="form-control" accept="image/*" onchange="previewIcon(this)">
            <img class="icon-preview" style="display:none;">
        </td>
        <td><input type="text" name="elements[${rowIndex}][title]" class="form-control" placeholder="Element Title"></td>
        <td><textarea name="elements[${rowIndex}][description]" class="form-control" rows="2" placeholder="Element Description"></textarea></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button></td>
    </tr>`;
    table.insertAdjacentHTML('beforeend', row);
    rowIndex++;
}

function removeRow(btn){
    btn.closest('tr').remove();
}
</script>
</body>
</html>
