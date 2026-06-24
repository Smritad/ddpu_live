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
        background: url('{{ asset('memberships/banner/' . ($membershipbenefits->banner_image ?? 'default.webp')) }}') center center no-repeat;
        background-size: cover;
    ">      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>Membership Benefits</h1>
            <ul class="bread-list">
              <li><a href="./">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">Services<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">Membership Benefits</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>


<section class="membership-benefits-custom-one">
  <div class="container">
    <div class="row">

      {{-- Left Image --}}
      <div class="col-md-6">
        <div class="membership-benefits-custom-one-img-sec">
          <img src="{{ asset('memberships/main/' . ($membershipbenefits->main_image ?? 'default.webp')) }}"
               class="img-fluid"
               alt="{{ $membershipbenefits->heading ?? 'Membership Benefits' }}">
        </div>
      </div>

      {{-- Right Content --}}
      <div class="col-md-6">
        <div class="membership-benefits-custom-content-sec">

          {{-- Heading --}}
          <div class="membership-benefits-custom-title-sec">
            <h2>{{ $membershipbenefits->heading ?? '' }}</h2>
          </div>

          {{-- Description --}}
          <p>
            {!! $membershipbenefits->description ?? '' !!}
          </p>

          {{-- Items --}}
          @php
              $items = $membershipbenefits->items;

              // if stored as string convert to array
              if (is_string($items)) {
                  $items = json_decode($items, true);
              }
          @endphp

          <div class="membership-benefits-points-subrow">
            <div class="row">

              @if(!empty($items) && is_array($items))
                
                {{-- split into 2 columns --}}
                @foreach(array_chunk($items, ceil(count($items)/2)) as $chunk)
                  <div class="col-md-6">
                    
                    @foreach($chunk as $item)
                      <div class="membership-benefits-cards-sec">
                        
                        {{-- Icon --}}
                        <div class="mbc-col-sec">
                          <img src="{{ asset('memberships/icons/' . ($item['icon'] ?? 'default.png')) }}" alt="">
                        </div>

                        {{-- Heading --}}
                        <div class="mbc-col-content-sec">
                          <h3>{{ $item['heading'] ?? '' }}</h3>
                        </div>

                      </div>
                    @endforeach

                  </div>
                @endforeach

              @endif

            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

   <section class="memebership-benefits-custom-two-sec">
  <div class="container">
    <div class="row">
      <div class="col-md-10">
        <div class="memebership-benefits-custom-two-content-sec">

          {!! $membershipbenefits->benefits_description ?? '' !!}

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