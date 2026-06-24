<!DOCTYPE html>
<html lang="en">

<head>
 @include('components.frontend.head')
</head>


<body class="index-page">
<header id="header" class="header sticky-top">
   @include('components.frontend.header')
 </header>

<style>
   /* FIRST header column (dark) */
.compare-us-table-sec thead th:first-child {
    background-color: #0f3b66;
    color: #ffffff;
}

/* OTHER header columns (light) */
.compare-us-table-sec thead th:not(:first-child) {
    background-color: #d9e6f2;
    color: #0f3b66;
}


</style>
  <main class="main">
    <section class="ddpu-breadcrumb-sec"
    style="
        background: url('{{ asset('compareus/banner/' . ($compareus->banner_image ?? 'default.webp')) }}') center center no-repeat;
        background-size: cover;">      
        <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>Compare Us</h1>
            <ul class="bread-list">
              <li><a href="./">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">Services<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">Compare Us</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

<section class="compare-us-one-sec">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <div class="compare-us-title-sec">
          <h2>{{ $compareus->heading ?? '' }}</h2>
        </div>

        @php
            $details = $compareus->details ?? [];
            $columns = $details['columns'] ?? [];
            $rows = $details['rows'] ?? [];
        @endphp

        <table class="compare-us-table-sec">

          {{-- HEADER --}}
          @if(!empty($columns))
          <thead>
              <tr>
                  @foreach($columns as $col)
                      <th>{{ $col }}</th>
                  @endforeach
              </tr>
          </thead>
          @endif

          {{-- BODY --}}
          @if(!empty($rows))
          <tbody>
              @foreach($rows as $row)
                  <tr>
                      @foreach($row as $cell)
                          <td>{{ $cell }}</td>
                      @endforeach
                  </tr>
              @endforeach
          </tbody>
          @endif

        </table>

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