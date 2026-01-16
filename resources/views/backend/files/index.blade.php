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

							</div>


                <div class="container-fluid">
                          

                        <div class="container-fluid">
    <h4>File Upload & Details</h4>
    <br>
{{-- Period Filter (From-To Date) --}}
    <div class="mb-4">
        <h5>Period Filter</h5>
        <form action="{{ route('files.details') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="from_date">From Date</label>
                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $fromDate ?? now()->subMonth()->format('Y-m-d') }}">
            </div>

            <div class="col-md-3">
                <label for="to_date">To Date</label>
                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $toDate ?? now()->format('Y-m-d') }}">
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100 mt-4">Apply Filter</button>
            </div>

            <div class="col-md-3">
                <a href="{{ route('files.details') }}" class="btn btn-secondary w-100 mt-4">Reset</a>
            </div>
        </form>
    </div>
    {{-- Upload Form --}}
    <form action="{{ route('files.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="row align-items-end">
            <div class="col-md-4">
                <label for="file">Upload File</label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv,.ods,.xml,.txt" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label for="collection_date">Collection Date</label>
                <input type="date" name="collection_date" class="form-control" required value="{{ now()->format('Y-m-d') }}">
            </div>

            <div class="col-md-3">
                <label for="notes">Notes (optional)</label>
                <input type="text" name="notes" class="form-control" placeholder="Add any notes">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100 mt-4">Import File</button>
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
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($files as $file)
                    <tr>
                        <td>
                            @php
                                $formattedDate = $file->collection_date
                                    ? \Carbon\Carbon::parse($file->collection_date)->format('y-m-d')
                                    : '—';
                                $fileTitle = 'DDPU (Monthly on the 10th)';
                                $note = $file->notes ? "({$file->notes})" : '';
                                $extension = pathinfo($file->file_name, PATHINFO_EXTENSION) ?: 'xlsx';
                            @endphp
                            {{ $formattedDate }} {{ $fileTitle }} {{ $note }}.{{ $extension }}
                        </td>
                        <td>{{ optional($file->collection_date)->format('d/m/Y') ?? '—' }}</td>
                        <td>{{ optional($file->uploaded_date)->format('d/m/Y H:i') }}</td>
                        <td>{{ $file->notes ?? '—' }}</td>
                        <td>{{ number_format($file->total_amount, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $file->status === 'uploaded' ? 'success' : ($file->status === 'failed' ? 'danger' : 'warning') }}">
                                {{ ucfirst($file->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('files.export', $file->id) }}" class="btn btn-success btn-sm">Export</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No files found in selected period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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