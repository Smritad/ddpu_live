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
        background: url('{{ asset('PrivateSectorDetails/banner/' . ($privatesectordetails->banner_image ?? 'default.webp')) }}') center center no-repeat;
        background-size: cover;
    ">      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>Private Sector & Academic Specialities</h1>
            <ul class="bread-list">
              <li><a href="./">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">Services<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">Private Sector & Academic Specialities</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>


<section class="private-sector-academic-speci-one-sec">
  <div class="container">
    <div class="row">

      <!-- IMAGE -->
      <div class="col-md-6">
        <div class="psaso-one-img-sec">
          <img src="{{ asset('PrivateSectorDetails/main/' . $privatesectordetails->main_image) }}" 
               class="img-fluid" 
               alt="{{ $privateSectorDetails->heading ?? 'Private Sector' }}">
        </div>
      </div>

      <!-- CONTENT -->
      <div class="col-md-6">
        <div class="psaso-content-sec">
          <div class="psaso-title-sec">
            <h2>{{ $privatesectordetails->heading ?? 'Doctors in Private / Independent Sector' }}</h2>
          </div>

          {!! $privatesectordetails->description ?? '' !!}

        </div>
      </div>

    </div>
  </div>
</section>

    <section class="private-sector-academic-speci-two-sec">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="our-exp-title-sec">
              <h2>{{ $privatesectordetails->academic_heading ?? 'Doctors in Private / Independent Sector' }}</h2>
            </div>
            <p>{!! $privatesectordetails->academic_description !!}</a></p>
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