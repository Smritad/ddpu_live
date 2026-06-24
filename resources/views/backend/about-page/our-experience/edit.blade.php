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
                  <h4>Edit Experience Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('our-experienced.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Experience Details</li>
                </ol>

                </div>
              </div>
            </div>
          </div>
         
            <div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Edit Experience Details</h4>
            <p class="text-muted">Update the details below and submit the form.</p>
        </div>
        <div class="card-body">
                    <form class="row g-4 needs-validation custom-input"
                          novalidate
                          action="{{ route('our-experienced.update', $experience->id) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Banner Upload -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Banner Image</label>
                            <input class="form-control"
                                   type="file"
                                   name="banner_image"
                                   accept=".jpg,.jpeg,.png,.webp,.svg"
                                   onchange="previewBannerImage(this)">
                            <small class="text-muted">Recommended size: 1200x500px</small>
                        </div>

                        <!-- Banner Preview -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Preview</label>

                            <div id="bannerPreviewBox"
                                 class="border rounded p-2 text-center"
                                 style="{{ $experience->banner_image ? '' : 'display:none;' }}">

                                <div class="position-relative d-inline-block">
                                    <span class="remove-img" onclick="removeBannerImage()">×</span>

                                    <img id="banner_preview"
                                         src="{{ $experience->banner_image ? asset('uploads/our-experience/'.$experience->banner_image) : '' }}"
                                         class="img-fluid rounded"
                                         style="max-height:180px;">
                                </div>
                            </div>
                        </div>

                        <!-- hidden delete flag -->
                        <input type="hidden" name="remove_banner" id="remove_banner" value="0">

                        <hr class="my-4">

                        <!-- Title -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   value="{{ old('title', $experience->title) }}"
                                   placeholder="Enter title"
                                   required>
                        </div>
<!-- Title -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Our Team Title</label>
                            <input type="text"
                                   name="team_title"
                                   class="form-control"
                                   value="{{ old('team_title', $experience->team_title) }}"
                                   placeholder="Enter team title"
                                   required>
                        </div>
                        <!-- Description -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" id="editor"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Enter description">{!! old('description', $experience->description) !!}</textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="col-12 text-end mt-4">
                            <a href="{{ route('our-experienced.index') }}"
                               class="btn btn-light border px-4 me-2">Cancel</a>
                            <button class="btn btn-primary px-4" type="submit">
                                Update
                            </button>
                        </div>

                    </form>
                        </div>
                    </div>
                </div>
                


{{-- ======================
    JavaScript Preview + Remove
======================= --}}
<script>
function previewBannerImage(input) {
    const preview = document.getElementById('banner_preview');
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
    }
}
</script>
<script>
function removeBannerImage() {
    document.getElementById('banner_preview').src = '';
    document.getElementById('bannerPreviewBox').style.display = 'none';
    document.querySelector('input[name="banner_image"]').value = '';
    document.getElementById('remove_banner').value = 1;
}
</script>


        </div>
        <!-- footer start-->
        @include('components.backend.footer')
        </div>
        </div>


       
       @include('components.backend.main-js')

</body>

</html>