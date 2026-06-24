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
											<a href="{{ route('customer-physical.details') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">Join customer Physical Details</li>
									</ol>
								</nav>

							</div>

                   
                    <div class="table-responsive custom-scrollbar">
                    <div class="table-responsive custom-scrollbar">
                    <table class="table table-bordered" id="basic-1">
            
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>DD Reference</th>
                                   
                                    <th>Payment Plan</th>
                                     <th>Direct Debit Form</th>
                                    <th>Direct Debit Form</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($memberships as $key => $member)

                                    @php
                                        $step1 = is_array($member->step1_signup)
                                            ? $member->step1_signup
                                            : json_decode($member->step1_signup, true);
                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>{{ $member->dd_reference ?? '-' }}</td>
                                        <td>{{ $step1['payment_plan'] ?? '-' }}</td>
                                       <td>{{ $step1['payment_plan'] ?? '-' }}</td>

                                        <td>
                                            @if(!empty($step1['file_name']))
                                                <a href="{{ asset('direct-debit/' . $step1['file_name']) }}" target="_blank">
                                                    {{ $step1['file_name'] }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>


                                        
                                        <td>
                                            {{ $member->submitted_at
                                                ? $member->submitted_at->format('d M Y')
                                                : $member->created_at->format('d M Y') }}
                                        </td>

                                         <td>
                                              <select class="form-select form-select-sm status-change"
                                                      data-id="{{ $member->id }}">
                                                  <option value="">Select</option>
                                                  <option value="pending"   {{ $member->status=='pending'?'selected':'' }}>Pending</option>
                                                  <option value="delivered" {{ $member->status=='delivered'?'selected':'' }}>Delivered</option>
                                                  <option value="expired"   {{ $member->status=='expired'?'selected':'' }}>Expired</option>
                                              </select>
                                          </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                          
                    </table>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Configure SweetAlert2 toast
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    });

    document.querySelectorAll('.status-change').forEach(select => {
        select.addEventListener('change', function () {

            const id     = this.dataset.id;
            const status = this.value;

            if (!status) return;

            fetch("{{ route('membership.status.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ id, status })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Status updated successfully'
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Update failed'
                    });
                }
            })
            .catch(() => {
                Toast.fire({
                    icon: 'error',
                    title: 'Update failed'
                });
            });
        });
    });

});
</script>
</body>

</html>