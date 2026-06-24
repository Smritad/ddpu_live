
<!DOCTYPE html>
<html lang="en">

<head>
     @include('components.frontend.head')

</head>
<style>.ddpu-listing-one {
    list-style-type: disc; /* normal bullets */
    padding-left: 20px;
}

.ddpu-listing-one li {
    margin-bottom: 10px;
    line-height: 1.6;
}
.ddpu-listing-one li::before {
    content: "\2713"; /* Unicode checkmark */
    color: #0b2e54;
    font-weight: bold;
    display: inline-block;
    width: 20px;
}

</style>

<body class="index-page">
  <header id="header" class="header sticky-top">

       @include('components.frontend.header')
</header>
  <main class="main">
<section class="ddpu-breadcrumb-sec"
    style="
        background: url('{{ asset('uploads/our-experience/' . ($ourexperience->banner_image ?? 'default.webp')) }}') center center no-repeat;
        background-size: cover;
    ">      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>Our Experience</h1>
            <ul class="bread-list">
              <li><a href="./">Home<i class="fa fa-angle-right"></i></a></li>
              <li><a href="#">About Us<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">Our Experience</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

  


 <section class="our-experience-one-sec">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="our-exp-content-sec">
              <div class="our-exp-title-sec">
                 <h2>{{ $ourexperience->title }}</h2>
                <p>{{ $ourexperience->team_title }}</p>
              </div>
              <ul class="ddpu-listing-one">
          {!! $ourexperience->description !!}
          </ul>
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

   @include('components.frontend.main-js')

</body>

</html>