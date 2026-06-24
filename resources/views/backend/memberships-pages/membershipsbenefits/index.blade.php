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
											<a href="{{ route('membership-benefits-details.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page"> Memberships Benefits</li>
									</ol>
								</nav>

								<a href="{{ route('membership-benefits-details.create') }}" class="btn btn-primary px-5 radius-30">+ Add Memberships Benefits Details</a>
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
                    
                        <tbody>
                            @foreach($memberships as $key => $practice)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                    
                                <td>
                                    <img src="{{ asset('memberships/banner/'.$practice->banner_image) }}"
                                         width="80"
                                         class="img-thumbnail">
                                </td>
                    
                               
                    
                                <td class="text-center">
                    
                                    <a href="{{ route('membership-benefits-details.edit',$practice->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                    
                                    <form action="{{ route('membership-benefits-details.destroy',$practice->id) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                    
                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this record?')">
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