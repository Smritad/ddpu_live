<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
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
                <h4>Edit Membership Details Form</h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('what-is-ddpu-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Membership Details</li>
                </ol>
            </div>
        </div>
    </div>

   <div class="card mt-3">
    <div class="card-header">
        <h4>Membership Details Form</h4>
        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
    </div>
@php
    $items = json_decode($membership->items, true);
@endphp

    <div class="card-body">
       <form class="row g-4"
      action="{{ route('membership-details.update', $membership->id) }}"
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
           accept=".jpg,.jpeg,.png,.webp,.svg"
           onchange="previewBanner(this)">

    <div class="position-relative d-inline-block mt-2">
        <img id="bannerPreview"
             src="{{ $membership->banner_image ? asset('membership/banner/'.$membership->banner_image) : '' }}"
             width="150"
             style="border:1px solid #ddd; padding:5px; {{ $membership->banner_image ? '' : 'display:none;' }}">

        <span class="remove-banner"
              onclick="removeBanner()"
              style="cursor:pointer;
                     position:absolute;
                     top:-8px;
                     right:-8px;
                     background:#dc3545;
                     color:#fff;
                     border-radius:50%;
                     width:20px;
                     height:20px;
                     text-align:center;
                     font-size:14px;
                     {{ $membership->banner_image ? '' : 'display:none;' }}">
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

    <textarea name="title"
              id="editor"
              class="form-control"
              required>{{ $membership->title }}</textarea>
</div>


<!-- ================= MULTIPLE ITEMS ================= -->
<div class="col-md-12 mt-3">
    <!--<label class="form-label fw-semibold">-->
    <!--    Membership Items-->
    <!--</label>-->

    <table class="table table-bordered" id="itemsTable">
        <thead>
            <tr>
                <th style="width: 30%;">Image</th>
                <th style="width: 30%;">Heading</th>
                <th style="width: 55%;">Description</th>
                <th style="width:80px;">Action</th>
            </tr>
        </thead>
        <tbody>

        @if($items)
            @foreach($items as $index => $item)
            <tr>
               <td>
    <input type="file"
           name="items[{{ $index }}][image]"
           class="form-control item-image"
           accept=".jpg,.jpeg,.png,.webp,.svg">

    <div class="position-relative d-inline-block mt-2">

        <img src="{{ !empty($item['image']) ? asset('membership/items/'.$item['image']) : '' }}"
             class="img-preview"
             width="80"
             style="border:1px solid #ddd; padding:3px;
                    {{ !empty($item['image']) ? '' : 'display:none;' }}">

        <span class="remove-image"
              style="cursor:pointer;
                     position:absolute;
                     top:-6px;
                     right:-6px;
                     background:#dc3545;
                     color:#fff;
                     border-radius:50%;
                     width:18px;
                     height:18px;
                     text-align:center;
                     font-size:12px;
                     {{ !empty($item['image']) ? '' : 'display:none;' }}">
            ×
        </span>

    </div>

    <small class="text-muted image-size d-block"></small>
</td>


                <td>
                    <input type="text"
                           name="items[{{ $index }}][heading]"
                           value="{{ $item['heading'] }}"
                           class="form-control"
                           required>
                </td>

                <td>
                    <textarea name="items[{{ $index }}][description]"
                              class="form-control"
                              rows="2"
                              required>{{ $item['description'] }}</textarea>
                </td>

                <td class="text-center">
                    @if($index == 0)
                        <button type="button" class="btn btn-success btn-sm addRow">+</button>
                    @else
                        <button type="button" class="btn btn-danger btn-sm removeRow">×</button>
                    @endif
                </td>
            </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>

<!-- ================= SUBMIT ================= -->
<div class="col-12 text-end">
            <a href="{{ route('membership-details.index') }}" class="btn btn-danger px-4">Cancel</a>

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
<script>

document.addEventListener('DOMContentLoaded', function () {

    // Set row index based on existing rows (for edit page support)
    let rowIndex = document.querySelectorAll('#itemsTable tbody tr').length;

    /* =========================================
       ADD ROW
    ========================================= */
    document.addEventListener('click', function (e) {

        if (e.target.classList.contains('addRow')) {

            let tbody = document.querySelector('#itemsTable tbody');

            let newRow = `
            <tr>
                <td>
                    <input type="file"
                           name="items[${rowIndex}][image]"
                           class="form-control item-image"
                           accept=".jpg,.jpeg,.png,.webp,.svg">

                    <div class="position-relative d-inline-block mt-2">
                        <img class="img-preview"
                             width="80"
                             style="display:none; border:1px solid #ddd; padding:3px;">

                        <span class="remove-image"
                              style="display:none;
                                     cursor:pointer;
                                     position:absolute;
                                     top:-6px;
                                     right:-6px;
                                     background:#dc3545;
                                     color:#fff;
                                     border-radius:50%;
                                     width:18px;
                                     height:18px;
                                     text-align:center;
                                     font-size:12px;">
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
                    <button type="button"
                            class="btn btn-danger btn-sm removeRow">
                        -
                    </button>
                </td>
            </tr>`;

            tbody.insertAdjacentHTML('beforeend', newRow);
            rowIndex++;
        }

        /* =========================================
           REMOVE ROW
        ========================================= */
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
        }

        /* =========================================
           REMOVE IMAGE PREVIEW
        ========================================= */
        if (e.target.classList.contains('remove-image')) {

            let td = e.target.closest('td');

            td.querySelector('.img-preview').src = "";
            td.querySelector('.img-preview').style.display = "none";
            td.querySelector('.item-image').value = "";
            td.querySelector('.image-size').innerHTML = "";
            e.target.style.display = "none";
        }
    });

    /* =========================================
       IMAGE PREVIEW
    ========================================= */
    document.addEventListener('change', function (e) {

        if (e.target.classList.contains('item-image')) {

            let file = e.target.files[0];
            let reader = new FileReader();

            let td = e.target.closest('td');
            let preview = td.querySelector('.img-preview');
            let removeBtn = td.querySelector('.remove-image');
            let sizeText = td.querySelector('.image-size');

            if (file) {

                reader.onload = function () {
                    preview.src = reader.result;
                    preview.style.display = "block";
                    removeBtn.style.display = "block";
                };

                reader.readAsDataURL(file);

                sizeText.innerHTML =
                    "Size: " + (file.size / 1024).toFixed(2) + " KB";
            }
        }
    });

});


/* =========================================
   BANNER PREVIEW
========================================= */
function previewBanner(input) {

    let file = input.files[0];
    let reader = new FileReader();

    if (file) {

        reader.onload = function () {

            let bannerImg = document.getElementById('bannerPreview');
            let removeBtn = document.querySelector('.remove-banner');

            bannerImg.src = reader.result;
            bannerImg.style.display = "block";
            removeBtn.style.display = "block";
        };

        reader.readAsDataURL(file);

        document.getElementById('bannerSize').innerHTML =
            "Size: " + (file.size / 1024).toFixed(2) + " KB";
    }
}


/* =========================================
   REMOVE BANNER
========================================= */
function removeBanner() {

    document.querySelector('input[name="banner_image"]').value = "";

    let bannerImg = document.getElementById('bannerPreview');
    let removeBtn = document.querySelector('.remove-banner');

    bannerImg.src = "";
    bannerImg.style.display = "none";
    removeBtn.style.display = "none";

    document.getElementById('bannerSize').innerHTML = "";
}

</script>


</body>
</html>
