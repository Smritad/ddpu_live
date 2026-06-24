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
											<a href="{{ route('aboutus-testimonials-details.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page"> DDPU Details</li>
									</ol>
								</nav>

								<a href="{{ route('aboutus-testimonials-details.create') }}" class="btn btn-primary px-5 radius-30">+ Add DDPU Details</a>
							</div>


                    <div class="table-responsive custom-scrollbar">
                    <table class="display" id="basic-1">
                       <thead>
<tr>
    <th>#</th>
    <th>Banner</th>
    <th>Testimonials</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($aboutustestimonials as $key => $row)

@php
    $items = json_decode($row->items, true);
@endphp

<tr>
    <td>{{ $key + 1 }}</td>

    <!-- Banner Image -->
    <td>
        <img src="{{ asset('uploads/aboutustestimonials/'.$row->banner_image) }}"
             width="100" class="img-thumbnail">
    </td>

    <!-- Multiple testimonials under one banner -->
    <td>
        @foreach($items as $item)
            <div class="d-flex align-items-center mb-2 p-2 border rounded">
                <img src="{{ asset('uploads/aboutustestimonials/'.$item['image']) }}"
                     width="50" height="50"
                     class="rounded-circle me-2">

                <strong>{{ $item['name'] }}</strong>
            </div>
        @endforeach
    </td>

    <!-- Action -->
    <td>
        <a href="{{ route('aboutus-testimonials-details.edit', $row->id) }}"
           class="btn btn-sm btn-primary mb-1">
            <i class="fa fa-edit"></i>
        </a>

        <form action="{{ route('aboutus-testimonials-details.destroy', $row->id) }}"
              method="POST"
              class="d-inline"
              onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i>
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