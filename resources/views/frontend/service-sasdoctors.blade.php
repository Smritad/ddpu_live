
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
        background: url('{{ asset('SasDoctorsNonTrainingGrades/banner/' . ($sasdoctors->banner_image ?? 'default.webp')) }}') center center no-repeat;
        background-size: cover;
    ">      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>SAS Doctors and Other Non-Training Grades</h1>
            <ul class="bread-list">
              <li><a href="./">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">Services<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">Hospital Practice<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">SAS Doctors and Other Non-Training Grades</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>



<section class="consultants-one-sec">
  <div class="container">

    <!-- TITLE -->
    <div class="consultants-one-title-sec">
      <h2>{{ $sasdoctors->heading ?? 'The Services Available to SAS Doctors and Doctors or Dentists in other Career and Non-Training Grades' }}</h2>
    </div>

    <div class="consultants-row-sec">
      <div class="row">

        @php
          $details = is_array($sasdoctors->details) 
                     ? $sasdoctors->details 
                     : json_decode($sasdoctors->details, true);

          $chunks = array_chunk($details ?? [], ceil(count($details ?? []) / 2));
        @endphp

        <!-- LEFT COLUMN -->
        <div class="col-md-6">
          <div class="accordion creative-accordion" id="consultantsAccordion">

            @foreach($chunks[0] ?? [] as $index => $item)
              @php $id = 'acc'.($index+1); @endphp

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#{{ $id }}">
                    {{ $item['title'] ?? '' }}
                    <span class="icon">+</span>
                  </button>
                </h2>

                <div id="{{ $id }}" class="accordion-collapse collapse"
                     data-bs-parent="#consultantsAccordion">
                  <div class="accordion-body">

                    @php
                      $desc = $item['description'] ?? '';
                      $desc = str_replace('<ul>', '<ul class="ddpu-listing-two">', $desc);
                    @endphp

                    {!! $desc !!}

                  </div>
                </div>
              </div>
            @endforeach

          </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-md-6">
          <div class="accordion creative-accordion" id="consultantsAccordionone">

            @foreach($chunks[1] ?? [] as $index => $item)
              @php $id = 'acc'.($index+4); @endphp

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#{{ $id }}">
                    {{ $item['title'] ?? '' }}
                    <span class="icon">+</span>
                  </button>
                </h2>

                <div id="{{ $id }}" class="accordion-collapse collapse"
                     data-bs-parent="#consultantsAccordionone">
                  <div class="accordion-body">

                    @php
                      $desc = $item['description'] ?? '';
                      $desc = str_replace('<ul>', '<ul class="ddpu-listing-two">', $desc);
                    @endphp

                    {!! $desc !!}

                  </div>
                </div>
              </div>
            @endforeach

          </div>
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