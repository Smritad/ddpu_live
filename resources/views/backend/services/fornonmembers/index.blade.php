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
											<a href="{{ route('for-non-members-details.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page"> For Non Members
</li>
									</ol>
								</nav>

								<a href="{{ route('for-non-members-details.create') }}" class="btn btn-primary px-5 radius-30">+ Add For Non Members
 Details</a>
							</div>


                    <div class="table-responsive custom-scrollbar">
                   <table class="display table table-bordered" id="basic-1">
    <thead>
        <tr>
            <th>#</th>
            <th>Banner</th>
            <th>Title</th>
            <th width="150">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($fornonmembers as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>

            <!-- Banner Image -->
            <td>
                @if($item->banner_image)
                    <img src="{{ asset('fornonmembers/banner/'.$item->banner_image) }}"
                         width="80"
                         style="border-radius:6px;">
                @else
                    N/A
                @endif
            </td>

            <!-- Title (Short Description Preview) -->
            <td>
                {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 50) }}
            </td>

            <!-- Action Buttons -->
            <td>
                <a href="{{ route('for-non-members-details.edit', $item->id) }}"
                   class="btn btn-sm btn-primary">
                   Edit
                </a>

                <form action="{{ route('for-non-members-details.destroy', $item->id) }}"
                      method="POST"
                      style="display:inline-block;">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure?')">
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