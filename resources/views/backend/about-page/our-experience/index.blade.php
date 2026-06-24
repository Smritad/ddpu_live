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
											<a href="{{ route('our-experienced.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page"> Our Experience Details</li>
									</ol>
								</nav>

								<a href="{{ route('our-experienced.create') }}" class="btn btn-primary px-5 radius-30">+ Add Our Experience Details</a>
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
                                        @forelse($ourExperiences as $index => $exp)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                
                                                <td>{{ $exp->title }}</td>
                                
                                                <td>
                                                    @if($exp->banner_image)
                                                        <img src="{{ asset('uploads/our-experience/'.$exp->banner_image) }}"
                                                             width="120"
                                                             style="border:1px solid #ddd; padding:4px;">
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                
                                                <td>
                                                    <a href="{{ route('our-experienced.edit', $exp->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>
                                                    </a>
                                
                                                    <form action="{{ route('our-experienced.destroy', $exp->id) }}"
                                                          method="POST"
                                                          style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No records found</td>
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