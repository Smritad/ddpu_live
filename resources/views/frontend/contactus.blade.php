
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
 <main class="main">
    <section class="ddpu-breadcrumb-sec">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>Contact</h1>
            <ul class="bread-list">
              <li><a href="./">Home<i class="fa fa-angle-right"></i></a></li>
              <li class="active"><a href="javascript:void(0)">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>


<section class="contact-us-form-sec">
  <div class="container">
    <div class="row">

      <!-- LEFT SIDE -->
      <div class="col-md-6">
        <div class="contact-us-form-title-sec">
          <h2>Questions? Send Us a Message!</h2>
        </div>

        <div class="contact-us-email-call-loaction-sec">

          <!-- PHONE -->
          <div class="contact-us-one-sec">
            <div class="contact-us-cea-sec">
              <div class="row">
                <div class="col-12 col-md-2">
                  <div class="con-cea-img-sec">
                    <i class="fa-solid fa-phone"></i>
                  </div>
                </div>
                <div class="col-12 col-md-10">
                  <div class="con-cea-cont-sec">
                    <h3>Call Us</h3>
                    <p>
                      <a href="tel:{{ $contact->phone ?? '' }}">
                        {{ $contact->phone ?? '' }}
                      </a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- EMAIL -->
          <div class="contact-us-one-sec">
            <div class="contact-us-cea-sec">
              <div class="row">
                <div class="col-12 col-md-2">
                  <div class="con-cea-img-sec">
                    <i class="fa-solid fa-envelope"></i>
                  </div>
                </div>
                <div class="col-12 col-md-10">
                  <div class="con-cea-cont-sec">
                    <h3>Email</h3>
                    <p>
                      <a href="mailto:{{ $contact->email ?? '' }}">
                        {{ $contact->email ?? '' }}
                      </a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- ADDRESS -->
          <div class="contact-us-one-sec">
            <div class="contact-us-cea-sec">
              <div class="row">
                <div class="col-12 col-md-2">
                  <div class="con-cea-img-sec">
                    <i class="fa-solid fa-location-dot"></i>
                  </div>
                </div>
                <div class="col-12 col-md-10">
                  <div class="con-cea-cont-sec">
                    <h3>Location</h3>
                    <p>
    @if(!empty($contact->address))
        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($contact->address) }}" target="_blank">
            {{ $contact->address }}
        </a>
    @endif
</p>

                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- RIGHT SIDE FORM -->
      <div class="col-md-6">
        <div class="contact-form-main-sec">
         <form class="contact-form" method="POST" action="{{ route('contact.send') }}" id="contactForm">
    @csrf

    <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="Your name" required>
    </div>

    <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Your email" required>
    </div>

    <div class="mb-3">
        <input type="text" name="subject" class="form-control" placeholder="Subject" required>
    </div>

    <div class="mb-3">
        <textarea name="message" class="form-control" rows="8" placeholder="Your message" required></textarea>
    </div>

    <button type="submit" class="contact-form-btn w-100">Submit</button>
</form>



        </div>
      </div>

    </div>
  </div>
</section>

   <div class="contact-us-map-sec">
    @if(!empty($contact->mapurl))
        {!! $contact->mapurl !!}
    @else
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1853.0191178120363!2d-2.3906622242440942!3d53.45372916668446!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487ba95f5ba16c29%3A0xb9c55b4d10c165c!2sThe%20Doctors%20and%20Dentists%20Protection%20Union!5e1!3m2!1sen!2sin!4v1767787978437!5m2!1sen!2sin"
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    @endif
</div>



    @include('frontend.includes.join-membership')

  </main>
      @include('components.frontend.footer')


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <!--<div id="preloader"></div>-->
    @include('components.frontend.main-js')


<!-- JS Validation -->
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    let form = e.target;
    let name = form.name.value.trim();
    let email = form.email.value.trim();
    let subject = form.subject.value.trim();
    let message = form.message.value.trim();

    if (!name || !email || !subject || !message) {
        alert('Please fill in all required fields.');
        e.preventDefault();
        return false;
    }

    // Basic email pattern check
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        e.preventDefault();
        return false;
    }

    // Form is valid, allow submission
});
</script>

</body>

</html>