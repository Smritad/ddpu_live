<!doctype html>
<html lang="en">
    
<head>
    @include('components.backend.head')
</head>
	   
		@include('components.backend.header')

	    <!--start sidebar wrapper-->	
	    @include('components.backend.sidebar')
	   <!--end sidebar wrapper-->


        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Edit Banner Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('banner-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Banner Details</li>
                </ol>

                </div>
              </div>
            </div>
          </div>
         
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Edit DDPU Details</h4>
            <p class="text-muted">Update the details below and submit the form.</p>
        </div>
        <div class="card-body">
           <form class="row g-4 needs-validation custom-input"
      novalidate
      action="{{ route('some-of-our-past-cases.update', $case->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Banner Image -->
    <div class="col-md-12">
        <label class="form-label fw-semibold">
            Banner Image <span class="txt-danger">*</span>
        </label>
        <input class="form-control"
               id="banner_image"
               type="file"
               name="banner_image"
               accept=".jpg,.jpeg,.png,.webp,.svg"
               onchange="previewSingleImage(this)">
        <small class="text-muted d-block mt-1">
            Allowed: JPG, JPEG, PNG, WEBP, SVG | Max size: ~10MB
        </small>
    </div>

   <!-- Banner Preview -->
<div class="col-md-12" id="bannerPreviewBox"
     style="margin-top:10px; display:{{ $case->banner_image ? 'block' : 'none' }}">

    <div style="position:relative; display:inline-block; max-width:220px;">

        <span class="remove-img"
              onclick="removeBannerImage()"
              style="
                position:absolute;
                top:5px;
                right:5px;
                background:red;
                color:white;
                width:24px;
                height:24px;
                text-align:center;
                line-height:24px;
                border-radius:50%;
                cursor:pointer;
                font-weight:bold;
                font-size:16px;
                z-index:5;">
            ×
        </span>

        <img id="bannerPreview"
             src="{{ $case->banner_image ? asset('uploads/past-cases/'.$case->banner_image) : '' }}"
             class="img-fluid border p-2"
             style="max-height:200px; width:100%; object-fit:cover; border-radius:6px;">
    </div>

</div>

    <!-- Description -->
    <div class="col-md-12">
        <label class="form-label fw-semibold">Description</label>
        <textarea id="editor" name="description" class="form-control" rows="5" placeholder="Enter description">{{ old('description', $case->description) }}</textarea>
    </div>

    <!-- Heading -->
    <div class="col-md-12">
        <label class="form-label fw-semibold">Heading</label>
        <input type="text" name="heading" class="form-control" placeholder="Enter heading"
               value="{{ old('heading', $case->heading) }}">
    </div>

    <h5 class="fw-semibold mt-3">Past Case Titles</h5>
<div class="col-md-12 table-responsive">
    <table class="table table-bordered" id="titlesTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Link</th>
                <th width="80">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($titles as $key => $row)
            <tr>
                <td>
                    <input type="text" name="titles[{{ $key }}][title]" class="form-control"
                        value="{{ $row['title'] ?? '' }}">
                </td>
                <td>
                    <input type="text" name="titles[{{ $key }}][link]" class="form-control"
                        value="{{ $row['link'] ?? '' }}" placeholder="https://example.com">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button>
                </td>
            </tr>
            @empty
            <tr>
                <td>
                    <input type="text" name="titles[0][title]" class="form-control" placeholder="Enter title">
                </td>
                <td>
                    <input type="text" name="titles[0][link]" class="form-control" placeholder="Enter link">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">+ Add More</button>
</div>


    <!-- Submit -->
    <div class="col-12 text-end mt-3">
        <a href="{{ route('banner-details.index') }}" class="btn btn-danger px-4">Cancel</a>
        <button class="btn btn-primary px-4" type="submit">Update</button>
    </div>
</form>


        </div>
    </div>
</div>




        </div>
        <!-- footer start-->
        @include('components.backend.footer')
        </div>
        </div>


       
       @include('components.backend.main-js')

{{-- ======================
    JavaScript Preview + Remove
======================= --}}
<script>

let rowIndex = {{ count($titles) ?? 1 }};

function addRow() {
    let table = document.querySelector('#titlesTable tbody');

    let row = `<tr>
        <td>
            <input type="text" name="titles[${rowIndex}][title]" class="form-control" placeholder="Enter title">
        </td>
        <td>
            <input type="text" name="titles[${rowIndex}][link]" class="form-control" placeholder="Enter link">
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button>
        </td>
    </tr>`;

    table.insertAdjacentHTML('beforeend', row);
    rowIndex++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}

document.addEventListener('DOMContentLoaded', function() {
    function previewSingleImage(input){
        if(input.files && input.files[0]){
            let previewBox = document.getElementById('bannerPreviewBox');
            let previewImg = document.getElementById('bannerPreview');

            previewImg.src = URL.createObjectURL(input.files[0]);
            previewBox.style.display = 'block';
        }
    }

    function removeBannerImage(){
        let input = document.getElementById('banner_image');
        input.value = '';
        document.getElementById('bannerPreviewBox').style.display = 'none';
    }

    window.previewSingleImage = previewSingleImage;
    window.removeBannerImage = removeBannerImage;
});
</script>
</body>

</html>