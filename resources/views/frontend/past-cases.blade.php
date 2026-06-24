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
        background: url('{{ asset('uploads/past-cases/' . ($someofourpastcases->banner_image ?? 'default.webp')) }}') center center no-repeat;
        background-size: cover;
    ">      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1> Some of Our Past Cases</h1>
            <ul class="bread-list">
              <li><a href="./">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">About Us<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">Some of Our Past Cases</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

  @if(!empty($someofourpastcases))

@php
    $titles = json_decode($someofourpastcases->titles, true) ?? [];
    $half = ceil(count($titles) / 2);
@endphp

<!-- SECTION ONE -->
<section class="some-of-our-past-cases-one-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="soopco-content-sec">
                    <ul class="ddpu-listing-one">
                        {!! $someofourpastcases->description ?? '' !!}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION TWO -->
<section class="some-of-our-past-cases-two-sec">
    <div class="container">
        <div class="row">

            <!-- HEADING -->
            <div class="col-md-12">
                <div class="our-exp-title-sec">
                    <h2>{{ $someofourpastcases->heading ?? '' }}</h2>
                </div>
            </div>

            <!-- LEFT COLUMN -->
            <div class="col-md-6">
                <div class="soopc-two-content-sec">
                    <ul class="ddpu-listing-two">
                        @foreach(array_slice($titles, 0, $half) as $case)
                            <li>
                                @if(!empty($case['link']))
                                    <a href="{{ $case['link'] }}" target="_blank">
                                        {{ $case['title'] }}
                                    </a>
                                @else
                                    {{ $case['title'] }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-md-6">
                <div class="soopc-two-content-sec">
                    <ul class="ddpu-listing-two">
                        @foreach(array_slice($titles, $half) as $case)
                            <li>
                                @if(!empty($case['link']))
                                    <a href="{{ $case['link'] }}" target="_blank">
                                        {{ $case['title'] }}
                                    </a>
                                @else
                                    {{ $case['title'] }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>


@endif

    @include('frontend.includes.join-membership')

  </main>
  @include('components.frontend.footer')
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>
 @include('components.frontend.main-js')

</body>

</html>