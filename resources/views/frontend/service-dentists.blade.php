
<!DOCTYPE html>
<html lang="en">

<head>
 @include('components.frontend.head')
</head>


<body class="index-page">
<header id="header" class="header sticky-top">
   @include('components.frontend.header')
 </header>

  <main class="main">
    <section class="ddpu-breadcrumb-sec"
    style="
        background: url('{{ asset('/dentists/banner/' . ($dentist->banner_image ?? 'default.webp')) }}') center center no-repeat;
        background-size: cover;
    ">      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>Dentist</h1>
            <ul class="bread-list">
              <li><a href="./">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">Services<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">Dentist</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>


   <section class="dentists-one-sec">
  <div class="container">
    <div class="row">

      <!-- IMAGE -->
      <div class="col-md-6">
        <div class="dentists-one-img-sec">
          <img src="{{ asset('/dentists/main/' . ($dentist->main_image ?? 'default.jpg')) }}" 
               class="img-fluid" alt="">
        </div>
      </div>

      <!-- CONTENT -->
      <div class="col-md-6">
        <div class="dentists-content-sec">

          <div class="dentists-title-sec">
            <h2>{{ $dentist->heading ?? 'Dentist Legal Representation' }}</h2>
          </div>

          <p>{!! $dentist->description !!}</p>

          {{-- if you have extra points stored in DB --}}
          @if(!empty($dentist->points))
            <ol type="a">
              @foreach($dentist->points as $point)
                <li>{{ $point }}</li>
              @endforeach
            </ol>
          @endif

        </div>
      </div>

    </div>
  </div>
</section>



    @include('frontend.includes.join-membership')
  </main>
  @include('components.frontend.footer')  <!-- Scroll Top -->
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

    @include('components.frontend.main-js')




</body>

</html>