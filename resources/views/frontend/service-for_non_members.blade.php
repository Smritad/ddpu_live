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
        background: url('{{ asset('/fornonmembers/banner/' . ($fornonmembershipdetails->banner_image ?? 'default.webp')) }}') center center no-repeat;
        background-size: cover;">      
        <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>For Non Members</h1>
            <ul class="bread-list">
              <li><a href="./">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">Services<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">For Non Members</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

<section class="for-non-members-one-sec">
  <div class="container">
    <div class="row">

      {{-- Image --}}
      <div class="col-md-6">
        <div class="for-non-members-one-img-sec">
          <img src="{{ asset('/fornonmembers/main/' . ($fornonmembershipdetails->main_image ?? 'default.webp')) }}"
               class="img-fluid"
               alt="{{ $fornonmembershipdetails->heading ?? 'For Non Members' }}">
        </div>
      </div>

      {{-- Content --}}
      <div class="col-md-6">
        <div class="for-non-members-content-sec">

          <div class="for-non-members-title-sec">
            <h2>{{ $fornonmembershipdetails->heading ?? '' }}</h2>
          </div>

          <p>
            {!! $fornonmembershipdetails->description !!}
          </p>

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