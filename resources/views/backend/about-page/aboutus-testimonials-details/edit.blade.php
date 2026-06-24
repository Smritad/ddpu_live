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
      action="{{ route('aboutus-testimonials-details.update', $testimonial->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- ================= Banner ================= -->
    <div class="col-md-12">
        <label class="form-label fw-semibold">
            Banner Image <span class="txt-danger">*</span>
        </label>
        <input class="form-control"
               type="file"
               name="banner_image"
               accept=".jpg,.jpeg,.png,.webp,.svg"
               onchange="previewSingleImage(this)">
    </div>

    <!-- Banner Preview -->
    <div class="col-md-12" id="bannerPreviewBox"
         style="display:{{ $testimonial->banner_image ? 'block' : 'none' }};">
        <div class="position-relative d-inline-block">
            <span class="remove-img" onclick="removeBannerImage()">×</span>
            <img id="banner_preview"
                 src="{{ $testimonial->banner_image ? asset('uploads/aboutustestimonials/'.$testimonial->banner_image) : '' }}"
                 style="max-height:200px;border:1px solid #ddd;padding:5px;">
        </div>
    </div>

    <!-- ================= Table ================= -->
    <h5 class="mt-4">Testimonials Details</h5>

    <div class="col-md-12 table-responsive">
        <table class="table table-bordered" id="detailsTable">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Profession</th>
                    <th>Description</th>
                    <th width="80">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $key => $item)
                <tr>
                    <td>
                        <input type="file" name="items[{{ $key }}][image]" onchange="previewRowImage(this)">
                        <img class="row-preview mt-1"
                             src="{{ asset('uploads/aboutustestimonials/'.$item['image']) }}"
                             style="max-height:60px; display:block;">
                        <input type="hidden" name="items[{{ $key }}][old_image]" value="{{ $item['image'] }}">
                    </td>

                    <td>
                        <input type="text" name="items[{{ $key }}][name]"
                               class="form-control" value="{{ $item['name'] }}">
                    </td>

                    <td>
                        <input type="text" name="items[{{ $key }}][profession]"
                               class="form-control" value="{{ $item['profession'] }}">
                    </td>

                    <td>
                        <textarea name="items[{{ $key }}][description]"
                                  class="form-control">{{ $item['description'] }}</textarea>
                    </td>

                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">+ Add More</button>
    </div>

    <!-- ================= Submit ================= -->
    <div class="col-12 text-end mt-3">
        <button class="btn btn-success px-4" type="submit">Update</button>
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
<!-- ================= Scripts ================= -->
<script>
let rowIndex = {{ count($items) }};

function addRow() {
    let table = document.querySelector('#detailsTable tbody');
    let row = `
    <tr>
        <td>
            <input type="file" name="items[${rowIndex}][image]" onchange="previewRowImage(this)">
            <img class="row-preview mt-1" style="max-height:60px; display:none;">
        </td>
        <td><input type="text" name="items[${rowIndex}][name]" class="form-control"></td>
        <td><input type="text" name="items[${rowIndex}][profession]" class="form-control"></td>
        <td><textarea name="items[${rowIndex}][description]" class="form-control"></textarea></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button></td>
    </tr>`;
    table.insertAdjacentHTML('beforeend', row);
    rowIndex++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}

function previewRowImage(input) {
    let img = input.nextElementSibling;
    img.src = URL.createObjectURL(input.files[0]);
    img.style.display = 'block';
}

function previewSingleImage(input){
    let box = document.getElementById('bannerPreviewBox');
    let img = document.getElementById('banner_preview');
    img.src = URL.createObjectURL(input.files[0]);
    box.style.display = 'block';
}

function removeBannerImage(){
    document.querySelector('input[name="banner_image"]').value = '';
    document.getElementById('bannerPreviewBox').style.display = 'none';
}
</script>

<!-- ================= Style ================= -->
<style>
.remove-img{
    position:absolute;
    top:-10px;
    right:-10px;
    background:red;
    color:#fff;
    width:25px;
    height:25px;
    text-align:center;
    line-height:25px;
    border-radius:50%;
    cursor:pointer;
}
</style>
</body>

</html>