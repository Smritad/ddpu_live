
<!DOCTYPE html>
<html lang="en">

<head>
 @include('components.frontend.head')
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

        @include('components.frontend.header')

  </header>
<br>
 <main class="main">

  <section id="thankyou" class="hero section d-flex align-items-center">
    <div class="container text-center" data-aos="fade-up">

      <div class="mb-4">
        <i class="bi bi-check-circle-fill text-success" style="font-size:80px;"></i>
      </div>

      <h1 class="mb-3">Thank You for Your Submission!</h1>

      <p class="lead mb-4">
        Your application has been successfully submitted.  
        Our team will review the details and get back to you shortly.
      </p>

   
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="{{ url('/') }}" class="btn btn-primary px-4 app-form-btn">
          Go to Homepage
        </a>

       
      </div>

    </div>
  </section>

</main>
<br>
      @include('components.frontend.footer')


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <!--<div id="preloader"></div>-->
    @include('components.frontend.main-js')

  

</body>

</html>