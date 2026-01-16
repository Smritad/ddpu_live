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
    .status-filter-group {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 6px;
        overflow: hidden;
        width: fit-content;
        background-color: #fff;
    }
    .status-filter-label {
        background-color: #f8f9fa;
        padding: 8px 16px;
        font-weight: 500;
        border-right: 1px solid #ccc;
        color: #333;
        white-space: nowrap;
    }
    .status-filter-select {
        border: none;
        padding: 8px 16px;
        outline: none;
        box-shadow: none;
        min-width: 149px;
        color: #333;
    }
    .status-filter-select:focus {
        box-shadow: none;
    }
</style>
    
     <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">                                       
                        <svg class="stroke-icon">
                          <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                        </svg></a></li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb mb-0">
										<li class="breadcrumb-item">
											<a href="{{ route('direct_debit.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page"> Paperless Details</li>
									</ol>
								</nav>

								<!-- <a href="{{ route('membership.details') }}" class="btn btn-primary px-5 radius-30">+ Add Membership Details</a> -->
							</div>

              <div class="container-fluid">

                  <!-- Filter + Action Buttons -->
                  <div class="row form-group" style="padding-left:0px; padding-right:0px;">
                      <div class="col-md-2" style="min-width:250px;">
                

              <div class="status-filter-group">
                  <span class="status-filter-label">Status</span>
                  <select class="form-select status-filter-select" id="cmbStatus" onchange="applyFilter();">
                      <option value="0">All</option>
                      <option value="1" selected>Unprocessed</option>
                      <option value="2">Processed</option>
                  </select>
              </div>

        </div>

        <div class="col-md-9">
            <a href="{{ route('direct_debit.create') }}" class="btn btn-primary" style="float:right; margin-left: 8px;">
                <span class="glyphicon glyphicon-plus"></span> Add Signup
            </a>

            <!-- Download Form -->
            <form id="downloadForm" action="{{ route('direct_debit.download') }}" method="POST" style="float:right; margin-left: 8px;">
                @csrf
                <input type="hidden" name="selected_ids" id="ApplicationsToDownload">
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-check"></span> Download Selected
                </button>
            </form>

            <!-- Create 0N File -->
            <button id="btnProcess" class="btn btn-primary" style="float:right; margin-left: 8px;">
                <span class="glyphicon glyphicon-check"></span> Create 0N File for Selected
            </button>

            <!-- Mark as Processed -->
            <button id="btnProcessMark" class="btn btn-primary" style="float:right; margin-left: 8px;">
                <span class="glyphicon glyphicon-check"></span> Mark as Processed
            </button>
        </div>
    </div>
<br><br>
    <!-- Applications Table -->
    <div class="row">
        <div class="col-md-12">
             <div class="table-responsive custom-scrollbar">
        <table class="table table-bordered" id="basic-1">
            <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>Sign Up Date</th>
                        <th>Reference</th>
                        <th>Account Name</th>
                        <th>Bank</th>
                        <th>Account No</th>
                        <th>Sort Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                    <tr>
                        <td><input type="checkbox" class="selectApp" value="{{ $app->id }}"></td>
                        <td>{{ $app->signup_date }}</td>
                        <td>{{ $app->reference }}</td>
                        <td>{{ $app->account_name }}</td>
                        <td>{{ $app->bank }}</td>
                        <td>{{ $app->account_no }}</td>
                        <td>{{ $app->sort_code }}</td>
                        <td>
                            <a href="{{ route('direct_debit.edit', $app->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit Application">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================================= -->
<!-- ======================== MODALS ============================== -->
<!-- ============================================================= -->

<!-- Warning Modal -->
<div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="warningLabel">Warning</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        No Paperless Signups selected.<br>
        Please select one or more items from the grid below.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Create 0N File Modal -->
<div class="modal fade" id="processModal" tabindex="-1" aria-labelledby="processLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="processLabel">File Upload Confirmation</h5>
      </div>
      <div class="modal-body">
        Are you sure you wish to process the selected application(s)?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="confirmProcess">Yes</button>
      </div>
    </div>
  </div>
</div>

<!-- Mark as Processed Modal -->
<div class="modal fade" id="markProcessedModal" tabindex="-1" aria-labelledby="markLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="markLabel">Mark as Processed Confirmation</h5>
      </div>
      <div class="modal-body">
        Are you sure you wish to mark the selected application(s) as processed?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="confirmMarkProcessed">Yes</button>
      </div>
    </div>
  </div>
</div>

<!-- ============================================================= -->
<!-- ======================== JAVASCRIPT ========================== -->
<!-- ============================================================= -->

<script>
document.addEventListener("DOMContentLoaded", function() {

    // Select/Deselect All
    $('#selectAll').on('click', function() {
        $('.selectApp').prop('checked', this.checked);
    });

    // Apply Filter
    window.applyFilter = function(){
        let status = $('#cmbStatus').val();
        window.location.href = "{{ url('direct-debit') }}" + "?status=" + status;
    }

    // Helper to open Bootstrap 5 modal
    function showWarning() {
        const warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
        warningModal.show();
    }

    // Download Selected
    $('#downloadForm').on('submit', function(e){
        let selected = $('.selectApp:checked').map(function(){ return this.value; }).get();
        if(selected.length === 0){
            e.preventDefault();
            showWarning();
            return false;
        }
        $('#ApplicationsToDownload').val(selected.join(','));
    });

    // Create 0N File
    $('#btnProcess').on('click', function(e){
        let selected = $('.selectApp:checked').map(function(){ return this.value; }).get();
        if(selected.length === 0){
            e.preventDefault();
            showWarning();
            return false;
        } else {
            const processModal = new bootstrap.Modal(document.getElementById('processModal'));
            processModal.show();
        }
    });

    // Mark as Processed
    $('#btnProcessMark').on('click', function(e){
        let selected = $('.selectApp:checked').map(function(){ return this.value; }).get();
        if(selected.length === 0){
            e.preventDefault();
            showWarning();
            return false;
        } else {
            const markModal = new bootstrap.Modal(document.getElementById('markProcessedModal'));
            markModal.show();
        }
    });

    // Confirm Process
    $('#confirmProcess').on('click', function(){
        let selected = $('.selectApp:checked').map(function(){ return this.value; }).get();
        $.post("{{ route('direct_debit.process') }}", {_token:'{{ csrf_token() }}', ids:selected}, function(){
            location.reload();
        });
    });

    // Confirm Mark Processed
    $('#confirmMarkProcessed').on('click', function(){
        let selected = $('.selectApp:checked').map(function(){ return this.value; }).get();
        $.post("{{ route('direct_debit.markProcessed') }}", {_token:'{{ csrf_token() }}', ids:selected}, function(){
            location.reload();
        });
    });

});
</script>





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


</body>

</html>