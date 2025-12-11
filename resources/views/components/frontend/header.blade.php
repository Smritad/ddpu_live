<div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="d-none d-md-flex align-items-center ddpu-tb-sub-sec-one">
          <a href="mailto:info@ddpu.co.uk"><i class="fa-solid fa-envelope"></i> info@ddpu.co.uk</a>
          <a href="tel:01618702193"><i class="fa-solid fa-phone"></i> 0161 870 2193</a>
        </div>
        <div class="ddpu-tb-sub-sec-two">
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
          <a href="#"><i class="fa-brands fa-youtube"></i></a>
          <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
          <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-end">
        <a href="{{ route('frontend.index') }}" class="logo d-flex align-items-center me-auto">
          <img src="{{ asset('frontend/assets/img/logo/ddpu-logo.jpg')}}" alt="DDPU Logo">
        </a>
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="{{ route('frontend.index') }}" class="active">Home</a></li>
            <li class="dropdown"><a href="#"><span>About Us</span> <i
                  class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="what-is-ddpu.html">What is DDPU?</a></li>
                <li><a href="staff-personnel.html">Staff Personnel</a></li>
                <li><a href="our-experience.html">Our Experience</a></li>
                <li><a href="#">Our Method</a></li>
                <li><a href="some-of-our-past-cases.html">Some of Our Past Cases</a></li>
                <li><a href="#">Testimonials</a></li>
              </ul>
            </li>
            <li class="dropdown"><a href="#"><span>Services</span> <i
                  class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="#">Membership</a></li>
                <li><a href="#">Dentists</a></li>
                <li><a href="#">General Practice (NHS)</a></li>
                <li class="dropdown"><a href="#"><span>Hospital Practice</span> <i
                      class="bi bi-chevron-down toggle-dropdown"></i></a>
                  <ul>
                    <li><a href="#">Consultants</a></li>
                    <li><a href="#">SAS Doctors and Other Non-<br>Training Grades</a></li>
                    <li><a href="#">Trainees</a></li>
                    <li><a href="#">Trust grade and ad hoc<br> appointees in NHS</a></li>
                  </ul>
                </li>
                <li><a href="#">Private Sector & Academic Specialities</a></li>
                <li><a href="#">Compare Us</a></li>
                <li><a href="#">For Non Members</a></li>
              </ul>
            </li>
            <li class="dropdown"><a href="#"><span>Membership</span> <i
                  class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="#">Membership Benefits</a></li>
                <li><a href="#">Membership Rates and Options</a></li>
                <li><a href="{{ route('joinmembership.form') }}" class="active">Join Membership</a></li>

              </ul>
            </li>
            <li><a href="#contact">Contact</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>