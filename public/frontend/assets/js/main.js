(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  mobileNavToggleBtn.addEventListener('click', mobileNavToogle);

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Auto generate the carousel indicators
   */
  document.querySelectorAll('.carousel-indicators').forEach((carouselIndicator) => {
    carouselIndicator.closest('.carousel').querySelectorAll('.carousel-item').forEach((carouselItem, index) => {
      if (index === 0) {
        carouselIndicator.innerHTML += `<li data-bs-target="#${carouselIndicator.closest('.carousel').id}" data-bs-slide-to="${index}" class="active"></li>`;
      } else {
        carouselIndicator.innerHTML += `<li data-bs-target="#${carouselIndicator.closest('.carousel').id}" data-bs-slide-to="${index}"></li>`;
      }
    });
  });

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Initiate Pure Counter
   */
  new PureCounter();

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Frequently Asked Questions Toggle
   */
  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

  /**
   * Correct scrolling position upon page load for URLs containing hash links.
   */
  window.addEventListener('load', function(e) {
    if (window.location.hash) {
      if (document.querySelector(window.location.hash)) {
        setTimeout(() => {
          let section = document.querySelector(window.location.hash);
          let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
          window.scrollTo({
            top: section.offsetTop - parseInt(scrollMarginTop),
            behavior: 'smooth'
          });
        }, 100);
      }
    }
  });

  /**
   * Navmenu Scrollspy
   */
  let navmenulinks = document.querySelectorAll('.navmenu a');

  function navmenuScrollspy() {
    navmenulinks.forEach(navmenulink => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
        navmenulink.classList.add('active');
      } else {
        navmenulink.classList.remove('active');
      }
    })
  }
  window.addEventListener('load', navmenuScrollspy);
  document.addEventListener('scroll', navmenuScrollspy);

})();


// Testimonials View More
$(document).ready(function () {
  let showCount = 3;
  const testimonials = $('.testimonial-one-sec .col-md-4');
  const viewMoreBtn = $('.testimonials-one-btn-sec a');

  testimonials.hide();
  testimonials.slice(0, showCount).show();

  viewMoreBtn.on('click', function (e) {
    e.preventDefault();
    const nextItems = testimonials.slice(showCount, showCount + 3);
    nextItems.stop(true, true).slideDown(500); // smooth slide animation
    showCount += 3;

    if (showCount >= testimonials.length) {
      viewMoreBtn.fadeOut(400); // fade out button smoothly
    }
  });
});




// // =============== Next & Back ====================================
// function updateFormHeight() {
//   let activeStep = $(".slider-step").filter(function () {
//     return $(this).css("opacity") == "1";
//   });

//   if (activeStep.length) {
//     $("#form-step-wrap").css("height", activeStep.outerHeight() + "px");
//   }
// }

// $(document).ready(function () {

//   // Set initial height
//   updateFormHeight();

//   // Next Step
//   $(".btn-next").on("click", function () {
//     let currentStep = $(this).closest(".slider-step");
//     let nextStep = $("#" + currentStep.data("nextStep"));

//     currentStep.attr("data-anim", "hide-to--left");
//     nextStep.attr("data-anim", "show-from--right");

//     setTimeout(updateFormHeight, 600);
//   });

//   // Back Step
//   $(".btn-back").on("click", function () {
//     let currentStep = $(this).closest(".slider-step");
//     let prevStep = $("#" + currentStep.data("backTo"));

//     currentStep.attr("data-anim", "hide-to--right");
//     prevStep.attr("data-anim", "show-from--left");

//     setTimeout(updateFormHeight, 600);
//   });

// });

// // Registration Year
// const picker = document.querySelector('.af-registration-year-picker');
// picker.addEventListener('focus', function () {
//   this.type = 'month';  // shows year selector
// });
// picker.addEventListener('blur', function () {
//   this.type = 'text';
// });


// // Qualification Year
// const qualPicker = document.querySelector('.af-qualification-year-picker');

// qualPicker.addEventListener('focus', function () {
//   this.type = 'month';  // shows month selector (Chrome hack)
// });

// qualPicker.addEventListener('blur', function () {
//   this.type = 'text';  // revert back to normal input
// });


// // =========
// const dobInput = document.querySelector('.app-date-picker');

// dobInput.addEventListener('focus', function () {
//   this.type = 'date';
// });

// dobInput.addEventListener('blur', function () {
//   if (!this.value) {
//     this.type = 'text';
//   }
// });



// // Show Password/ Hide password
// document.querySelectorAll('.toggle-password').forEach(icon => {
//   icon.addEventListener('click', function () {
//     const input = document.querySelector(this.dataset.target);

//     if (input.type === "password") {
//       input.type = "text";
//       this.classList.remove("fa-eye");
//       this.classList.add("fa-eye-slash");
//     } else {
//       input.type = "password";
//       this.classList.remove("fa-eye-slash");
//       this.classList.add("fa-eye");
//     }
//   });
// });


// //==================================== Job Title and Grade ======================
// document.getElementById("emp-status").addEventListener("change", function () {
//   const employedFields = document.querySelectorAll(".employed-field");
  
//   if (this.value === "employed") {
//     employedFields.forEach(el => el.classList.remove("d-none"));
//   } else {
//     employedFields.forEach(el => el.classList.add("d-none"));
//   }
// });


// // =======================================
// $(".pni-option").on("change", function () {
//   // Uncheck all except the clicked one
//   $(".pni-option").not(this).prop("checked", false);
// });



// // =================
// let currentStep = 1;
// const totalSteps = 7;

// function updateStepUI(step) {

//     const wrapper = document.getElementById("progressWrapper");
//     const fill = document.querySelector(".progress-fill");
//     const items = document.querySelectorAll(".progress-steps li");

//     // Hide on Step 8 (thank you)
//     if (step === 8) {
//         wrapper.style.display = "none";
//         return;
//     }

//     wrapper.style.display = "block";

//     // Fill line animation
//     let percent = ((step - 1) / (totalSteps - 1)) * 100;
//     fill.style.width = percent + "%";

//     // Step circles
//     items.forEach((item, index) => {
//         item.classList.remove("active", "completed");

//         if (index + 1 < step) {
//             item.classList.add("completed");
//         }

//         if (index + 1 === step) {
//             item.classList.add("active");
//         }
//     });
// }

// // Next buttons
// document.querySelectorAll(".btn-next").forEach(btn => {
//     btn.addEventListener("click", () => {
//         currentStep++;
//         if (currentStep > 8) currentStep = 8;
//         updateStepUI(currentStep);
//     });
// });

// // Back buttons
// document.querySelectorAll(".btn-back").forEach(btn => {
//     btn.addEventListener("click", () => {
//         currentStep--;
//         if (currentStep < 1) currentStep = 1;
//         updateStepUI(currentStep);
//     });
// });
