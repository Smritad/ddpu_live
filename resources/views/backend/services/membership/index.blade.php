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
											<a href="{{ route('membership-details.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page"> Membership</li>
									</ol>
								</nav>

								<a href="{{ route('membership-details.create') }}" class="btn btn-primary px-5 radius-30">+ Add Membership Details</a>
							</div>


                    <div class="table-responsive custom-scrollbar">
                    <table class="display" id="basic-1">
    <thead>
        <tr>
            <th>#</th>
           
            <th>Banner</th>
             <th>Title</th>
            <th width="150">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($memberships as $key => $membership)
        <tr>
            <td>{{ $key + 1 }}</td>
                    <td>
                @if($membership->banner_image)
                    <img src="{{ asset('membership/banner/'.$membership->banner_image) }}" 
                         width="80" 
                         style="border:1px solid #ddd; padding:3px;">
                @endif
            </td>
            <td>{!! $membership->title !!}</td>

           

            <td>
                <!-- Edit Button -->
                <a href="{{ route('membership-details.edit', $membership->id) }}" 
                   class="btn btn-sm btn-primary">
                    Edit
                </a>

                <!-- Delete Button -->
                <form action="{{ route('membership-details.destroy', $membership->id) }}" 
                      method="POST" 
                      style="display:inline-block;"
                      onsubmit="return confirm('Are you sure you want to delete this record?');">
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