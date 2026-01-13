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
											<a href="{{ route('files.details') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page"> Details</li>
									</ol>
								</nav>

								<!-- <a href="{{ route('membership.details') }}" class="btn btn-primary px-5 radius-30">+ Add Membership Details</a> -->
							</div>


                <div class="container-fluid">
                  <h4>File Upload & Details</h4>
                      <br>
                              {{-- Upload Form --}}
                              <form action="{{ route('files.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                                  @csrf
                                  <div class="row align-items-end">
                                  <div class="col-md-3">
                                      <label for="file">Upload File</label>
                                      <input type="file" name="file" accept=".xlsx,.xls,.csv,.ods,.xml,.txt" class="form-control" required>
                                  </div>

                                  <div class="col-md-3">
                                      <label for="collection_date">Collection Date</label>
                                      <input type="date" name="collection_date" class="form-control" required>
                                  </div>

                                  <div class="col-md-3">
                                      <button class="btn btn-primary w-100">Import File</button>
                                  </div>
                                  </div>
                              </form>

                            

                                

                                  {{-- Table Section --}}
                                  <div class="table-responsive custom-scrollbar">
                                    <table class="table table-bordered" id="basic-1">
                                      <thead>
                                        <tr>
                                          <th>File Name</th>
                                          <th>Collection Date</th>
                                          <th>Date Uploaded</th>
                                          <th>Notes</th>
                                          <th>Total Amount</th>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($files as $file)
                                        <tr>
                                        <td>
                                          @php
                                            $formattedDate = $file->collection_date
                                                ? \Carbon\Carbon::parse($file->collection_date)->format('y-m-d')
                                                : '';
                                            $fileTitle = 'DDPU (Monthly on the 10th)';
                                            $note = $file->notes ? "({$file->notes})" : '';
                                            $extension = pathinfo($file->file_name, PATHINFO_EXTENSION) ?: 'xlsx';
                                          @endphp

                                          {{ $formattedDate }} {{ $fileTitle }} {{ $note }}.{{ $extension }}
                                        </td>
                                          <td>{{ optional($file->collection_date)->format('d/m/Y') ?? $file->collection_date }}</td>
                                          <td>{{ optional($file->uploaded_date)->format('d/m/Y H:i') ?? $file->uploaded_date }}</td>
                                          <td>{{ $file->notes }}</td>
                                          <td>{{ number_format($file->total_amount, 2) }}</td>
                                          <td>
                                            <a href="{{ route('files.export', $file->id) }}" class="btn btn-success btn-sm">Export</a>
                                          </td>
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
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

{{-- JavaScript for Filter Logic --}}

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const periodSelect = document.getElementById('periodSelect');
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');

    periodSelect.addEventListener('change', function() {
      if (this.value === 'custom') {
        fromDate.disabled = false;
        toDate.disabled = false;
      } else {
        fromDate.disabled = true;
        toDate.disabled = true;
        fromDate.value = '';
        toDate.value = '';
      }
    });
  });
</script>

</body>

</html>