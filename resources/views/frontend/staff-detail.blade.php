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

    {{-- Breadcrumb with dynamic banner --}}
    <section class="ddpu-breadcrumb-sec"
        style="
            background: url('{{ asset('uploads/staff-personnel/' . ($staff->banner_image ?? 'default.webp')) }}') center center no-repeat;
            background-size: cover;
        ">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>{{ $staff->name }}</h1>
            <ul class="bread-list">
              <li><a href="{{ url('/') }}">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">About Us<i class="fa fa-angle-right"></i></a></li>
              <li><a href="{{ route('frontend.staffpersonnel') }}">Staff Personnel<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">{{ $staff->name }}</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    {{-- Staff Details --}}
    <section class="staff-personnel-team-details-sec">
      <div class="container">
        <div class="row staff-row">

          {{-- Left Column: Image, Name, Title, Social Links --}}
          <div class="col-lg-4 staff-image-col">
            <div class="staff-image-wrapper">
              <img src="{{ asset('uploads/staff-personnel/' . ($staff->profile_image ?? 'default-profile.webp')) }}" alt="{{ $staff->name }}">

              <div class="staff-details-name-sec">
                <h2>{{ $staff->name }}</h2>
                <h4>{{ $staff->designation }}</h4>
                <p>{{ $staff->title }}</p>
              </div>

              {{-- Social Links --}}
              <div class="staff-details-social-sec">
                @if(!empty($staff->social_links) && is_array($staff->social_links))
                  @foreach($staff->social_links as $social)
                    <a href="{{ $social['link'] ?? '#' }}" target="_blank">
                      @switch(strtolower($social['name']))
                        @case('facebook')
                          <i class="fa-brands fa-facebook-f"></i>
                          @break
                        @case('instagram')
                          <i class="fa-brands fa-instagram"></i>
                          @break
                        @case('twitter')
                          <i class="fa-brands fa-x-twitter"></i>
                          @break
                        @case('linkedin')
                        @case('linked')
                          <i class="fa-brands fa-linkedin-in"></i>
                          @break
                        @default
                          <i class="fa-solid fa-link"></i>
                      @endswitch
                    </a>
                  @endforeach
                @endif
              </div>

            </div>
          </div>

          {{-- Right Column: Description --}}
          <div class="col-lg-8 staff-content-col">
            <div class="staff-content">
              {!! $staff->description !!}
            </div>
          </div>

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

  @include('components.frontend.main-js')
</body>

</html>