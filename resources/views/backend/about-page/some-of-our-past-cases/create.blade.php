<!doctype html>
<html lang="en">
    
<head>
    @include('components.backend.head')
</head>
	   
		@include('components.backend.header')

	    <!--start sidebar wrapper-->	
	    @include('components.backend.sidebar')
	   <!--end sidebar wrapper-->

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
}
</style>

        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Add Banner Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('what-is-ddpu-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Banner Details</li>
                </ol>

                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts -->
          <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <h4>Banner Details Form</h4>
                    <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                </div>

                <div class="card-body">
                 <form class="row g-4 needs-validation custom-input"
                          novalidate
                          action="{{ route('some-of-our-past-cases.store') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                    
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
                               required
                               onchange="previewSingleImage(this)">
                        <small class="text-muted d-block mt-1">
                            Allowed: JPG, JPEG, PNG, WEBP, SVG | Max size: ~10MB
                        </small>
                    </div>
                    
                    <!-- Banner Preview -->
                    <div class="col-md-12" id="bannerPreviewBox" style="display:none; margin-top:10px;">
                        <div style="position:relative; display:inline-block;">
                            <span class="remove-img" onclick="removeBannerImage()" 
                                  style="position:absolute; top:-10px; right:-10px; background:red; color:white; 
                                         width:28px; height:28px; text-align:center; line-height:28px; 
                                         border-radius:50%; cursor:pointer; font-weight:bold; z-index:10;">×</span>
                            <img id="bannerPreview" class="img-fluid border p-2" style="max-height:200px; display:block;">
                        </div>
                    </div>
                    
                    
                    
                    
                        <!-- Description -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea id="editor" name="description" class="form-control" rows="5" placeholder="Enter description"></textarea>
                        </div>
                    
                        <!-- Heading -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Heading</label>
                            <input type="text" name="heading" class="form-control" placeholder="Enter heading, e.g., Own Cases of Rajendar Chaoudhary">
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
        </tbody>
    </table>

    <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">+ Add More</button>
</div>

                        <!-- Submit -->
                        <div class="col-12 text-end mt-3">
                            <a href="{{ route('banner-details.index') }}" class="btn btn-danger px-4">Cancel</a>
                            <button class="btn btn-primary px-4" type="submit">Submit</button>
                        </div>
                    </form>



                </div>

            </div>
        </div>
    </div>
</div>

        </div>
        <!-- footer start-->
        @include('components.backend.footer')
        </div>
        </div>


       
       @include('components.backend.main-js')
<script>
let rowIndex = 1;

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
</script>

<script>
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
        input.value = ''; // clear input
        document.getElementById('bannerPreviewBox').style.display = 'none'; // hide preview
    }

    // expose functions globally for inline onclick
    window.previewSingleImage = previewSingleImage;
    window.removeBannerImage = removeBannerImage;

});
</script>
</body>

</html>