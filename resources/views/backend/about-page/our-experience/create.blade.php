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
                  <h4>Add Our Experience Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('our-experienced.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Our Experience Details</li>
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
      action="{{ route('our-experienced.store') }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf

    <!-- Banner Image -->
    <div class="col-md-12">
        <label class="form-label fw-semibold">
            Banner Image <span class="text-danger">*</span>
        </label>
        <input class="form-control"
               type="file"
               name="banner_image"
               accept=".jpg,.jpeg,.png,.webp,.svg"
               required
               onchange="previewBannerImage(this)">
        <small class="text-muted d-block mt-1">
            Allowed: JPG, JPEG, PNG, WEBP, SVG | Max size: ~10MB
        </small>
        <div class="invalid-feedback">Please upload a banner image.</div>
    </div>

    <!-- Banner Preview -->
    <div class="col-md-12" id="bannerPreviewBox" style="display:none;">
        <label class="form-label fw-semibold">Preview</label>
        <div class="position-relative d-inline-block">
            <span class="remove-img" onclick="removeBannerImage()">×</span>
            <img id="banner_preview"
                 class="img-fluid"
                 style="max-height:200px; border:1px solid #ddd; padding:5px;">
        </div>
    </div>

    <!-- Title -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            Title <span class="text-danger">*</span>
        </label>
        <input type="text"
               name="title"
               class="form-control"
               placeholder="Enter title"
               required>
        <div class="invalid-feedback">Please enter a title</div>
    </div>
<div class="col-md-6">
                            <label class="form-label fw-semibold">Our Team Title</label>
                            <input type="text"
                                   name="team_title"
                                   class="form-control"
                                   value="{{ old('team_title', $experience->team_title) }}"
                                   placeholder="Enter team_title"
                                   required>
                        </div>
    <!-- Description -->
    <div class="col-md-12">
        <label class="form-label fw-semibold">
            Description
        </label>
        <textarea name="description" id="editor"
                  class="form-control"
                  rows="3"
                  placeholder="Enter description (optional)"></textarea>
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
        <!-- ========================== -->
        <!-- JS for Banner Preview -->
        <!-- ========================== -->
        <script>
            function previewBannerImage(input) {
                const previewBox = document.getElementById('bannerPreviewBox');
                const preview = document.getElementById('banner_preview');
        
                if (input.files && input.files[0]) {
                    preview.src = URL.createObjectURL(input.files[0]);
                    previewBox.style.display = 'block';
                }
            }
        
            function removeBannerImage() {
                const input = document.querySelector('input[name="banner_image"]');
                const previewBox = document.getElementById('bannerPreviewBox');
                const preview = document.getElementById('banner_preview');
        
                input.value = '';
                preview.src = '';
                previewBox.style.display = 'none';
            }
        </script>
</body>

</html>