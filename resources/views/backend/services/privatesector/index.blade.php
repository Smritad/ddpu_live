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
											<a href="{{ route('private-sectoracademic-details.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page"> Private Sector Detail</li>
									</ol>
								</nav>

								<a href="{{ route('private-sectoracademic-details.create') }}" class="btn btn-primary px-5 radius-30">+ Add Private Sector Detail</a>
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
                                    @forelse($privatesector as $key => $item)
                                        <tr>
                                            <!-- Serial No -->
                                            <td class="text-center">{{ $key + 1 }}</td>
                            
                                            <!-- Banner Image -->
                                            <td class="text-center">
                                                <img src="{{ asset('PrivateSectorDetails/banner/' . $item->banner_image) }}"
                                                     width="80"
                                                     style="border-radius:6px; border:1px solid #ddd;">
                                            </td>
                            
                                            <!-- Heading -->
                                            <td>{{ $item->heading }}</td>
                            
                                            <!-- Actions -->
                                            <td class="text-center">
                                                
                                                <!-- Edit Button -->
                                                <a href="{{ route('private-sectoracademic-details.edit', $item->id) }}"
                                                   class="btn btn-sm btn-primary me-1">
                                                    Edit
                                                </a>
                            
                                                <!-- Delete Button -->
                                                <form action="{{ route('private-sectoracademic-details.destroy', $item->id) }}"
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
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No data found</td>
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