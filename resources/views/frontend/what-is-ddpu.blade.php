
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
        background: url('{{ asset('whatddpu/banner/' . ($ddpu->banner_image ?? 'default.webp')) }}') center center no-repeat;
        background-size: cover;
    ">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>What is DDPU?</h1>
        <ul class="bread-list">
          <li><a href="{{ url('/') }}">Home<i class="fa fa-angle-right"></i></a></li>
          <li><a href="#">About Us<i class="fa fa-angle-right"></i></a></li>
          <li class="active"><a href="javascript:void(0)">What is DDPU?</a></li>
        </ul>
      </div>
    </div>
  </div>
</section>


@php
    $galleryImages = [];

    if (isset($ddpu) && !empty($ddpu->gallery_images)) {
        $galleryImages = is_array($ddpu->gallery_images)
            ? $ddpu->gallery_images
            : json_decode($ddpu->gallery_images, true);
    }
@endphp


<section class="what-is-ddpu-one-sec">
  <div class="container">
    <div class="row">

      <!-- TITLE -->
      <div class="col-lg-12">
        <div class="what-is-ddpu-one-title-sec">
          <h2>{{ $ddpu->title ?? 'Our Aim' }}</h2>
        </div>
      </div>

      <!-- IMAGES -->
      <div class="col-lg-6">
        <div class="image-section" data-aos="fade-left" data-aos-delay="200">

          <!-- Main Image -->
          <div class="main-image">
            @if(isset($galleryImages[0]))
              <img src="{{ asset('whatddpu/banner/' . $galleryImages[0]) }}"
                   class="img-fluid"
                   alt="DDPU Image">
            @endif
          </div>

          <!-- Grid Images -->
          <div class="image-grid">
            @foreach(array_slice($galleryImages, 1, 2) as $img)
              <div class="grid-item">
                <img src="{{ asset('whatddpu/banner/' . $img) }}"
                     class="img-fluid"
                     alt="DDPU Image">
              </div>
            @endforeach
          </div>

        </div>
      </div>

      <!-- PROFESSIONAL DESCRIPTION -->
      <div class="col-lg-6">
        <div class="what-is-ddpu-one-content-sec">
          {!! $ddpu->professional_description ?? '' !!}
        </div>
      </div>

      <!-- COMPARE DESCRIPTION -->
      <div class="col-lg-12">
        <div class="what-is-ddpu-one-content-second-sec">
          {!! $ddpu->compare_description ?? '' !!}
        </div>
      </div>

    </div>
  </div>
</section>

    @include('frontend.includes.join-membership')
  </main>
   @include('components.frontend.footer')  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <!--<div id="preloader"></div>-->

   @include('components.frontend.main-js')

</body>

</html>