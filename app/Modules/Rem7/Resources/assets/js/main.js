(function($) {
  "use strict";

  $(window).on('load', function() {


  // Sticky Nav
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 50) {
            $('.scrolling-navbar').addClass('top-nav-collapse');
        } else {
            $('.scrolling-navbar').removeClass('top-nav-collapse');
        }
    });

    // one page navigation
    $('.navbar-nav').onePageNav({
      currentClass: 'active'
    });




      /* WOW Scroll Spy
    ========================================================*/
     var wow = new WOW({
      //disabled for mobile
        mobile: false
    });

    wow.init();






    // /* Back Top Link active
    // ========================================================*/
    //   var offset = 200;
    //   var duration = 500;
    //   $(window).scroll(function() {
    //     if ($(this).scrollTop() > offset) {
    //       $('.back-to-top').fadeIn(400);
    //     } else {
    //       $('.back-to-top').fadeOut(400);
    //     }
    //   });

    //   $('.back-to-top').on('click',function(event) {
    //     event.preventDefault();
    //     $('html, body').animate({
    //       scrollTop: 0
    //     }, 600);
    //     return false;
    //   });

    //   /* Map Form Toggle
    //   ========================================================*/
    //   $('.map-icon').on('click',function (e) {
    //       $('#conatiner-map').toggleClass('panel-show');
    //       e.preventDefault();
    //   });

  });

}(jQuery));
