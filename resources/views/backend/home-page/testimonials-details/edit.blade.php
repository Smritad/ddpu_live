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
                  <h4>Edit Testimonials Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('testimonials-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Testimonials Details</li>
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
                        <h4>testimonials Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                            <form class="row g-4 needs-validation" novalidate action="{{ route('testimonials-details.update', $testimonials->id) }}" method="POST" enctype="multipart/form-data"> 
                                @csrf
                                @method('PUT')

                                <!-- Main Heading -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="main_heading">Main Heading <span class="text-danger">*</span></label>
                                        <input type="text" name="main_heading" id="main_heading" class="form-control" 
                                            value="{{ $testimonials->main_heading }}" placeholder="Enter main heading" required>
                                        <div class="invalid-feedback">Please enter a main heading.</div>
                                    </div>
                                </div>

                                <!-- Dynamic Table -->
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title mb-0">Testimonials</h5>
                                                <button type="button" class="btn btn-success" onclick="addRow()">
                                                    <i class="bi bi-plus-circle"></i> Add Row
                                                </button>
                                            </div>
                                            <table class="table table-bordered align-middle" id="testimonialsTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Description</th>
                                                        <th>Name</th>
                                                        <th>Designation</th>
                                                        <th style="width:120px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($testimonials->testimonials as $testimonial)
                                                    <tr>
                                                        <td><textarea name="description[]" class="form-control" rows="2" required>{{ $testimonial['description'] }}</textarea></td>
                                                        <td><input type="text" name="name[]" class="form-control" value="{{ $testimonial['name'] }}" required></td>
                                                        <td><input type="text" name="designation[]" class="form-control" value="{{ $testimonial['designation'] }}" required></td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger w-100" onclick="removeRow(this)"><i class="bi bi-trash"></i> Remove</button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="col-12 text-end mt-3">
                                    <a href="{{ route('testimonials-details.index') }}" class="btn btn-outline-danger px-4 me-2">Cancel</a>
                                    <button class="btn btn-primary px-4" type="submit">Update</button>
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

<script>
    function addRow() {
        const table = document.getElementById('testimonialsTable').getElementsByTagName('tbody')[0];
        const row = table.insertRow();
        row.innerHTML = `
            <td><textarea name="description[]" class="form-control" placeholder="Enter description" rows="2" required></textarea></td>
            <td><input type="text" name="name[]" class="form-control" placeholder="Enter name" required></td>
            <td><input type="text" name="designation[]" class="form-control" placeholder="Enter designation" required></td>
            <td>
                <button type="button" class="btn btn-danger w-100" onclick="removeRow(this)"><i class="bi bi-trash"></i> Remove</button>
            </td>
        `;
    }

    function removeRow(button) {
        button.closest('tr').remove();
    }
</script>
</body>

</html>