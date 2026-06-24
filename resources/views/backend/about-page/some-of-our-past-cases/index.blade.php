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
											<a href="{{ route('some-of-our-past-cases.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page"> Past Cases Details</li>
									</ol>
								</nav>

								<a href="{{ route('some-of-our-past-cases.create') }}" class="btn btn-primary px-5 radius-30">+ Add Past Cases Details</a>
							</div>


                    <div class="table-responsive custom-scrollbar">
                    <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Banner</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cases as $index => $case)
                                    <tr>
                                        <!-- Serial Number -->
                                        <td>{{ $index + 1 }}</td>
                            
                                        <!-- Heading -->
                                        <td>{{ $case->heading }}</td>
                            
                                        <!-- Banner Image -->
                                        <td>
                                            @if($case->banner_image && file_exists(public_path('uploads/past-cases/'.$case->banner_image)))
                                                <img src="{{ asset('uploads/past-cases/'.$case->banner_image) }}" 
                                                     alt="Banner" style="max-height:60px; border-radius:5px;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                            
                                        <!-- Actions -->
                                        <td>
                                            <a href="{{ route('some-of-our-past-cases.edit', $case->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            
                                            <form action="{{ route('some-of-our-past-cases.destroy', $case->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure to delete this case?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No Past Cases found.</td>
                                    </tr>
                                    @endforelse
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