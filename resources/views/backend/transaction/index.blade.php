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
        <div class="col-6"><h4>File Details List</h4></div>
        <div class="col-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">
              <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg>
            </a></li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
             <!-- Export Button -->
           <a href="{{ route('file.details.export') }}" class="btn btn-sm btn-primary">
    Export CSV
</a>
<br>
<br>
            <div class="table-responsive">
             <div class="table-responsive custom-scrollbar">
        <table class="table table-bordered" id="basic-1">
            <thead>
                  <tr>
                    <th>DD Ref</th>
                    <th>Account Name</th>
                    <th>Collection Date</th>
                    <th>BACS Code</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Filename</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($fileDetails as $detail)
                    @php
                        $coll    = $detail->file->collection_date ?? null;
                        $collFmt = $coll ? \Carbon\Carbon::parse($coll)->format('d/m/Y') : 'N/A';
                        $ext     = strtolower(pathinfo($detail->file->file_name ?? '', PATHINFO_EXTENSION) ?: 'csv');
                        $fileNice = $coll
                            ? \Carbon\Carbon::parse($coll)->format('y-m-d') . " DDPU (Monthly on the 10th).{$ext}"
                            : ($detail->file->file_name ?? 'N/A');
                        $st      = strtolower($detail->status ?? 'processing');
                        $stClass = $st === 'paid' ? 'badge-success' : ($st === 'failed' ? 'badge-danger' : 'badge-warning');
                    @endphp
                    <tr>
                      <td>{{ $detail->dd_reference }}</td>
                      <td>{{ $detail->account_name }}</td>
                      <td>{{ $collFmt }}</td>
                      <td>{{ $detail->bacs_code }}</td>
                      <td>{{ number_format((float) $detail->amount, 2) }}</td>
                      <td>
                        <span class="badge {{ $stClass }}">{{ ucfirst($detail->status ?? 'processing') }}</span>
                      </td>
                      <td>{{ $fileNice }}</td>
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