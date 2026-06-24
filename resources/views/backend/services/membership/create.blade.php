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
                        <a href="{{ route('membership-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Membership Details</li>
                </ol>
            </div>
        </div>
    </div>

  
<div class="card mt-3">
    <div class="card-header">
        <h4>Membership Details Form</h4>
        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
    </div>

    <div class="card-body">
       <form class="row g-4"
      action="{{ route('membership-details.store') }}"
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
           accept=".jpg,.jpeg,.png,.webp,.svg"
           required
           onchange="previewBanner(this)">

    <div class="position-relative d-inline-block mt-2">
        <img id="bannerPreview" width="150" style="display:none; border:1px solid #ddd; padding:5px;">
        <span class="remove-banner"
              onclick="removeBanner()"
              style="display:none; cursor:pointer; position:absolute; top:-8px; right:-8px; background:#dc3545; color:#fff; border-radius:50%; width:20px; height:20px; text-align:center; font-size:14px;">
            ×
        </span>
    </div>

    <small id="bannerSize" class="text-muted d-block"></small>
</div>

<!-- ================= TITLE ================= -->
<div class="col-md-12">
    <label class="form-label fw-semibold">
        Title <span class="text-danger">*</span>
    </label>
    <input type="text"
           name="title"
           class="form-control"
           placeholder="Enter Membership Title"
           required>
</div>

<!-- ================= MULTIPLE ITEMS ================= -->
<div class="col-md-12 mt-3">
    <!--<label class="form-label fw-semibold">-->
    <!--    Membership Items-->
    <!--</label>-->

    <table class="table table-bordered" id="itemsTable">
        <thead>
            <tr>
                <th style="width:200px;">Image</th>
                <th>Heading</th>
                <th>Description</th>
                <th style="width:80px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="file"
                           name="items[0][image]"
                           class="form-control item-image"
                           accept=".jpg,.jpeg,.png,.webp,.svg"
                           required>

                    <div class="position-relative d-inline-block mt-2">
                        <img class="img-preview" width="80"
                             style="display:none; border:1px solid #ddd; padding:3px;">
                        <span class="remove-image"
                              style="display:none; cursor:pointer; position:absolute; top:-6px; right:-6px; background:#dc3545; color:#fff; border-radius:50%; width:18px; height:18px; text-align:center; font-size:12px;">
                            ×
                        </span>
                    </div>

                    <small class="text-muted image-size d-block"></small>
                </td>

                <td>
                    <input type="text"
                           name="items[0][heading]"
                           class="form-control"
                           placeholder="Enter Heading"
                           required>
                </td>

                <td>
                    <textarea name="items[0][description]"
                              class="form-control"
                              rows="2"
                              placeholder="Enter Description"
                              required></textarea>
                </td>

                <td class="text-center">
                    <button type="button" class="btn btn-success btn-sm addRow">+</button>
                </td>
            </tr>
        </tbody>
    </table>
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
let rowIndex = 1;

// ================= ADD / REMOVE ROW =================
document.addEventListener('click', function(e) {

    if (e.target.classList.contains('addRow')) {

        let table = document.querySelector('#itemsTable tbody');

        let newRow = `
        <tr>
            <td>
                <input type="file"
                       name="items[${rowIndex}][image]"
                       class="form-control item-image"
                       required>

                <div class="position-relative d-inline-block mt-2">
                    <img class="img-preview" width="80"
                         style="display:none; border:1px solid #ddd; padding:3px;">
                    <span class="remove-image"
                          style="display:none; cursor:pointer; position:absolute; top:-6px; right:-6px; background:#dc3545; color:#fff; border-radius:50%; width:18px; height:18px; text-align:center; font-size:12px;">
                        ×
                    </span>
                </div>

                <small class="text-muted image-size d-block"></small>
            </td>
            <td>
                <input type="text"
                       name="items[${rowIndex}][heading]"
                       class="form-control"
                       placeholder="Enter Heading"
                       required>
            </td>
            <td>
                <textarea name="items[${rowIndex}][description]"
                          class="form-control"
                          rows="2"
                          placeholder="Enter Description"
                          required></textarea>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm removeRow">-</button>
            </td>
        </tr>`;

        table.insertAdjacentHTML('beforeend', newRow);
        rowIndex++;
    }

    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
    }

    // Remove Image Preview
    if (e.target.classList.contains('remove-image')) {
        let td = e.target.closest('td');
        td.querySelector('.img-preview').style.display = "none";
        td.querySelector('.remove-image').style.display = "none";
        td.querySelector('.image-size').innerHTML = "";
        td.querySelector('.item-image').value = "";
    }
});

// ================= IMAGE PREVIEW =================
document.addEventListener('change', function(e) {

    if (e.target.classList.contains('item-image')) {

        let file = e.target.files[0];
        let reader = new FileReader();
        let td = e.target.closest('td');
        let preview = td.querySelector('.img-preview');
        let removeBtn = td.querySelector('.remove-image');
        let sizeText = td.querySelector('.image-size');

        if (file) {
            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = "block";
                removeBtn.style.display = "block";
            };
            reader.readAsDataURL(file);

            sizeText.innerHTML = "Size: " + (file.size/1024).toFixed(2) + " KB";
        }
    }
});

// ================= BANNER PREVIEW =================
function previewBanner(input) {
    let file = input.files[0];
    let reader = new FileReader();

    if (file) {
        reader.onload = function() {
            document.getElementById('bannerPreview').src = reader.result;
            document.getElementById('bannerPreview').style.display = "block";
            document.querySelector('.remove-banner').style.display = "block";
        };
        reader.readAsDataURL(file);

        document.getElementById('bannerSize').innerHTML =
            "Size: " + (file.size/1024).toFixed(2) + " KB";
    }
}

function removeBanner() {
    document.querySelector('input[name="banner_image"]').value = "";
    document.getElementById('bannerPreview').style.display = "none";
    document.querySelector('.remove-banner').style.display = "none";
    document.getElementById('bannerSize').innerHTML = "";
}
</script>


</body>
</html>
