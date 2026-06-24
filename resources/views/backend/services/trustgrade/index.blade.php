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
											<a href="{{ route('trust-grade-details.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page"> Trust Grade Detail</li>
									</ol>
								</nav>

								<a href="{{ route('trust-grade-details.create') }}" class="btn btn-primary px-5 radius-30">+ Add Trust Grade Detail</a>
							</div>


                     <div class="table-responsive custom-scrollbar">
                   <table class="display table table-bordered table-striped align-middle" id="basic-1">
                        <thead class="table-light text-center">
                                <tr>
                                    <th width="60">#</th>
                                    <th width="120">Banner</th>
                                    <th>Heading</th>
                                    <th width="150" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trustgradedetails as $index => $trainees)
                                    <tr class="text-center">
                                        <td>{{ $index + 1 }}</td>
                        
                                        <!-- Banner Image -->
                                        <td>
                                            @if($trainees->banner_image)
                                                <img src="{{ asset('TrustGradeDetails/banner/'.$trainees->banner_image) }}" 
                                                     alt="Banner" style="width:100px; border-radius:5px;">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                        
                                        <!-- Heading -->
                                        <td>{{ $trainees->heading }}</td>
                        
                                        <!-- Action Buttons -->
                                        <td class="text-center">
                                            <a href="{{ route('trust-grade-details.edit', $trainees->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                        
                                            <form action="{{ route('trust-grade-details.destroy', $trainees->id) }}" 
                                                  method="POST" style="display:inline-block;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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