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
                  <h4>Add Why choose Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('whychoose-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add wWhy choose Details</li>
                </ol>

                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header">
                        <h4>whychoose Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                            <form class="row g-4 needs-validation" novalidate action="{{ route('whychoose-details.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Card: Main Heading -->
                                        <div class="col-12">
                                            <div class="card shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-3">Main Heading <span class="text-danger">*</span></h5>
                                                    <input type="text" name="main_heading" class="form-control" placeholder="Enter main heading" required>
                                                    <div class="invalid-feedback">Please enter a main heading.</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card: whychoose Details Table -->
                                        <div class="col-12">
                                            <div class="card shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5 class="card-title mb-0">whychoose Details</h5>
                                                        <button type="button" class="btn btn-success" onclick="addRow()">
                                                            <i class="bi bi-plus-circle"></i> Add Row
                                                        </button>
                                                    </div>

                                                    <table class="table table-bordered align-middle" id="whychooseTable">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width:120px;">Icon Image</th>
                                                                <th>Title</th>
                                                                <th style="width:120px;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="file" name="icon[]" accept=".jpg,.jpeg,.png,.webp,.svg"
                                                                        class="form-control icon-input mb-1" onchange="previewIconImage(this)">
                                                                    <img class="icon-preview img-thumbnail" style="max-width:50px; display:none;">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="title[]" class="form-control" placeholder="Enter title" required>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger w-100" onclick="removeRow(this)">
                                                                        <i class="bi bi-trash"></i> Remove
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end mt-3">
                                            <a href="{{ route('whychoose-details.index') }}" class="btn btn-outline-danger px-4 me-2">Cancel</a>
                                            <button class="btn btn-primary px-4" type="submit">Submit</button>
                                        </div>
                            </form>




                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
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

<!-- Optional JS Preview & Row Management -->
<script>
    // Add new row
    function addRow() {
        const table = document.getElementById('whychooseTable').getElementsByTagName('tbody')[0];
        const row = table.insertRow();
        row.innerHTML = `
            <td>
                <input type="file" name="icon[]" accept=".jpg,.jpeg,.png,.webp,.svg" class="form-control icon-input mb-1" onchange="previewIconImage(this)">
                <img class="icon-preview img-thumbnail" style="max-width:50px; display:none;">
            </td>
            <td><input type="text" name="title[]" class="form-control" placeholder="Enter title" required></td>
            <td>
                <button type="button" class="btn btn-danger w-100" onclick="removeRow(this)"><i class="bi bi-trash"></i> Remove</button>
            </td>
        `;
    }

    // Remove row
    function removeRow(button) {
        button.closest('tr').remove();
    }

    // Preview icon image
    function previewIconImage(input) {
        const file = input.files[0];
        const preview = input.nextElementSibling;
        if(file){
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>
</body>

</html>