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
        background: url('{{ asset('uploads/our-method/' . ($ourmethod->banner_image ?? 'default.webp')) }}') center center no-repeat;
        background-size: cover;
    ">      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>Our Method</h1>
            <ul class="bread-list">
              <li><a href="./">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">About Us<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">Our Method</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

<section class="our-method-one-sec">
    <div class="container">
        <div class="row align-items-center">

            <!-- IMAGE COLUMN -->
            <div class="col-md-6">
                <div class="our-method-one-img-sec">
                    @if(!empty($ourmethod->strategic_image))
                        <img 
                            src="{{ asset('uploads/our-method/' . $ourmethod->strategic_image) }}" 
                            class="img-fluid" 
                            alt="{{ $ourmethod->strategic_title ?? 'Our Method' }}">
                    @endif
                </div>
            </div>

            <!-- CONTENT COLUMN -->
            <div class="col-md-6">
                <div class="our-exp-title-sec">
                    <h2>{{ $ourmethod->strategic_title ?? '' }}</h2>
                </div>

                <p>
    {!! nl2br(str_replace('©', '<sup>©</sup>', $ourmethod->strategic_description ?? '')) !!}
</p>

            </div>

        </div>
    </div>
</section>

@php
    $elements = json_decode($ourmethod->elements, true);
@endphp

<section class="our-method-two-sec">
    <div class="container">
        <div class="row">

            <!-- SECTION TITLE -->
            <div class="col-md-12">
                <div class="what-is-ddpu-one-title-sec">
                    <h2>Elements of Strategic Intensive Case Management (SICM)</h2>
                </div>
            </div>


            <!-- ELEMENTS LOOP -->
            @if(!empty($elements))
                @foreach($elements as $item)
                    <div class="col-md-12">
                        <div class="our-method-two-col-sec">
                            <div class="row">

                                <!-- ICON + TITLE -->
                                <div class="col-md-3">
                                    <div class="our-method-img-title-sec">
                                        <div class="omit-img-sec"
                                             style="">
                                            @if(!empty($item['icon']))
                                                <img
                                                    src="{{ asset('uploads/our-method/elements/'.$item['icon']) }}"
                                                    alt="{{ $item['title'] ?? '' }}"
                                                    style="">
                                            @endif
                                        </div>
                                        <h3>{{ $item['title'] ?? '' }}</h3>
                                    </div>
                                </div>

                                <!-- DESCRIPTION -->
                                <div class="col-md-9">
                                    <div class="our-method-two-para-sec">
                                        {!! $item['description'] ?? '' !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</section>


    @include('frontend.includes.join-membership')
  </main>
   @include('components.frontend.footer')
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <!--<div id="preloader"></div>-->

  <!-- Vendor JS Files -->
   @include('components.frontend.main-js')

</body>

</html>