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
											<a href="{{ route('membership-rates-details.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page"> Memberships Rate Option</li>
									</ol>
								</nav>

								<a href="{{ route('membership-rates-details.create') }}" class="btn btn-primary px-5 radius-30">+ Add Memberships Rate Option Details</a>
							</div>


                    <div class="table-responsive custom-scrollbar">
                   <table class="display table table-bordered table-striped align-middle" id="basic-1">
    <thead class="table-light text-center">
        <tr>
            <th width="60">#</th>
            <th width="120">Banner</th>
            <th width="150" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach($membershipsList as $key => $membership)
        <tr>
            <td>{{ $key + 1 }}</td>

            <!-- Banner Image -->
            <td>
                @if($membership->banner_image && file_exists(public_path('memberships/banner/'.$membership->banner_image)))
                    <img src="{{ asset('memberships/banner/'.$membership->banner_image) }}" width="100" style="border-radius:4px; border:1px solid #ddd;">
                @else
                    <span class="text-muted">No Image</span>
                @endif
            </td>

            <!-- Action Buttons -->
            <td class="text-center">
                <a href="{{ route('membership-rates-details.edit', $membership->id) }}" class="btn btn-sm btn-primary">
                    Edit
                </a>

                <form action="{{ route('membership-rates-details.destroy', $membership->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure to delete this item?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        Delete
                    </button>
                </form>
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
            <!-- footer start-->
             @include('components.backend.footer')
      </div>
    </div>

        @include('components.backend.main-js')

</body>

</html>