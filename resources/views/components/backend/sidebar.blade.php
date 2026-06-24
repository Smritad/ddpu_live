<!-- Page Body Start-->
 <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper" data-layout="stroke-svg">
          <div class="logo-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="" alt="" style="max-width: 20% !important;"></a>
		  	<a href="{{ route('admin.dashboard') }}">
				<img class="img-fluid" src="{{ asset('admin/assets/images/logo/ddpu-logo.jpg') }}" alt="" style="max-width: 65% !important;">
			</a>  
		  <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
          </div>
          <div class="logo-icon-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo/favicon.png') }}" alt="" ></a></div>
          <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
              <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo-icon.png') }}" alt=""></a>
                  <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                </li>
             
                <li class="sidebar-list {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                    </svg>
                    <span class="lan-3">Dashboard</span>
                  </a>
                </li>

                <li class="sidebar-list {{ request()->routeIs('banner-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <span>Home page</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('banner-details.index') }}" class="{{ request()->routeIs('banner-details.index') ? 'active' : '' }}">Banner Details</a></li>
                     <li><a href="{{ route('aim-details.index') }}" class="{{ request()->routeIs('aim-details.index') ? 'active' : '' }}">Aim Details</a></li>
                     <li><a href="{{ route('whychoose-details.index') }}" class="{{ request()->routeIs('whychoose-details.index') ? 'active' : '' }}">Why Choose Details</a></li>
                     <li><a href="{{ route('testimonials-details.index') }}" class="{{ request()->routeIs('testimonials-details.index') ? 'active' : '' }}">Testimonials Details</a></li>
                     <li><a href="{{ route('joinmembership-details.index') }}" class="{{ request()->routeIs('joinmembership-details.index') ? 'active' : '' }}">Join membership Details</a></li>
                     <li><a href="{{ route('footer-details.index') }}" class="{{ request()->routeIs('footer-details.index') ? 'active' : '' }}">Footer Details</a></li>

                  </ul>
                </li>
                
                <li class="sidebar-list {{ request()->routeIs('what-is-ddpu-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <span>About Us</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('what-is-ddpu-details.index') }}" class="{{ request()->routeIs('what-is-ddpu-details.index') ? 'active' : '' }}">What is DDPU</a></li>
                    <li><a href="{{ route('staff-personnel.index') }}" class="{{ request()->routeIs('staff-personnel.index') ? 'active' : '' }}">What is Staff </a></li>
                    <li><a href="{{ route('our-experienced.index') }}" class="{{ request()->routeIs('our-experienced.index') ? 'active' : '' }}">Our Experience</a></li>
                    <li><a href="{{ route('our-methods.index') }}" class="{{ request()->routeIs('our-methods.index') ? 'active' : '' }}">Our Method</a></li>
                    <li><a href="{{ route('some-of-our-past-cases.index') }}" class="{{ request()->routeIs('some-of-our-past-cases.index') ? 'active' : '' }}">Some of Our Past Cases </a></li>
                     <li><a href="{{ route('aboutus-testimonials-details.index') }}" class="{{ request()->routeIs('aboutus-testimonials-details.index') ? 'active' : '' }}">Testimonials</a></li>

                  </ul>
                </li>


            <li class="sidebar-list {{ request()->routeIs('membership-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <span>Services</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('membership-details.index') }}" class="{{ request()->routeIs('membership-details.index') ? 'active' : '' }}">Membership</a></li>
                     <li><a href="{{ route('dentists-details.index') }}" class="{{ request()->routeIs('dentists-details.index') ? 'active' : '' }}">Dentists</a></li>
                     <li><a href="{{ route('general-practice-details.index') }}" class="{{ request()->routeIs('general-practice-details.index') ? 'active' : '' }}">General Practice</a></li>

                    <li><a class="submenu-title" href="#">Hospital Practice<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a>
                      <ul class="nav-sub-childmenu submenu-content">
                        <li><a href="{{ route('consultants-details.index') }}">Consultants</a></li>
                        <li><a href="{{ route('sas-doctors-grades-details.index') }}">SAS Doctors and Other Non-Training Grades</a></li>
                        <li><a href="{{ route('trainees-details.index') }}">Trainees Detail</a></li>
                        <li><a href="{{ route('trust-grade-details.index') }}">Trust Grade And Ad Hoc Appointees In NHS</a></li>
                       
                      </ul>
                    </li>
                    
                                     <li><a href="{{ route('private-sectoracademic-details.index') }}" class="{{ request()->routeIs('private-sectoracademic-details.index') ? 'active' : '' }}">Private Sector</a></li>
                                     <li><a href="{{ route('compare-us-details.index') }}" class="{{ request()->routeIs('compare-us-details.index') ? 'active' : '' }}">Compare Us</a></li>
                                     <li><a href="{{ route('for-non-members-details.index') }}" class="{{ request()->routeIs('for-non-members-details.index') ? 'active' : '' }}">For Non Members
</a></li>

                  </ul>

                </li>
             <li class="sidebar-list {{ request()->routeIs('membership-benefits-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <span>Membership</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('membership-benefits-details.index') }}" class="{{ request()->routeIs('membership-benefits-details.index') ? 'active' : '' }}">Membership benefits</a></li>
                    
                    <li><a href="{{ route('membership-rates-details.index') }}" class="{{ request()->routeIs('membership-rates-details.index') ? 'active' : '' }}">Membership Rates Option</a></li>
                    
                  </ul>
                </li>
                <li class="sidebar-list {{ request()->routeIs('banner-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <span>Join Membership</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('files.details') }}" class="{{ request()->routeIs('files.details') ? 'active' : '' }}">Files</a></li>
                     <li><a href="{{ route('transaction.details') }}" class="{{ request()->routeIs('transaction.details') ? 'active' : '' }}">Transactions</a></li>
                    <!-- <li><a href="{{ route('membership.details') }}" class="{{ request()->routeIs('membership.details') ? 'active' : '' }}">Customers </a></li> -->
                     <li><a href="{{ route('customer-elctronic.details') }}" class="{{ request()->routeIs('customer-elctronic.details') ? 'active' : '' }}">User Details</a></li>
                     <!--<li><a href="{{ route('customer-physical.details') }}" class="{{ request()->routeIs('customer-physical.details') ? 'active' : '' }}">Customers (Physical)</a></li>-->
                     <li><a href="{{ route('direct_debit.index') }}" class="{{ request()->routeIs('direct_debit.index') ? 'active' : '' }}">Paperles Signups</a></li>
                   <!-- <li><a href="">Submissions Reminders  </a></li>
                   <li><a href="">Reports </a></li> -->
                   <!-- <li><a href="">Import from Xero  </a></li>
                   <li><a href="">Zero Settings  </a></li> -->
                   <!-- <li><a href="">Change Password  </a></li> -->
                   <!-- <li><a href="">Downloads  </a></li> -->

                  </ul>
                </li>
            
 
                 


              </ul>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </div>


        