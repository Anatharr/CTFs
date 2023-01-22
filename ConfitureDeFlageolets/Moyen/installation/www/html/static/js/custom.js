(function () {
  "use strict";

  function handleNavbar() {
    var top = $(document).scrollTop();
    if (top <= $("#lineup").offset().top-3*$("#nav").outerHeight()) {
      $("#nav").addClass("bg-transparent");
      $("#nav").removeClass("bg-secondary");
      $("#nav").removeClass("bg-complementary");
    } else if (top <= $("#sponsors").offset().top-$("#nav").outerHeight()-10) {
      $("#nav").removeClass("bg-transparent");
      $("#nav").addClass("bg-secondary");
      $("#nav").removeClass("bg-complementary");
    }
    else {
      $("#nav").removeClass("bg-transparent");
      $("#nav").removeClass("bg-secondary");
      $("#nav").addClass("bg-complementary");
    }
  }

  handleNavbar()


  $(window).scroll(handleNavbar);

  $('a[href="#"]').click(function (event) {
    event.preventDefault();
  });

  $("#button-discover").hover(function (event) {
    if ($("#button-discover-overlay").hasClass("opacity-100")) {
      $("#button-discover-overlay").removeClass("opacity-100");
      $("#button-discover-overlay").addClass("opacity-0");
    } else {
      $("#button-discover-overlay").removeClass("opacity-0");
      $("#button-discover-overlay").addClass("opacity-100");
    }
  });
  
  $("body").on('click', '.nav-link', function (event) {
    if ($(this).attr('href')[0] == '#') {
      event.preventDefault();
      $('.nav-link').each(function (index) {
        $(this).removeClass('active')
      })
      $(this).addClass('active')

      $([document.documentElement, document.body]).animate({
        scrollTop: $($(this).attr('href')).offset().top-$("#nav").outerHeight()+1
      }, 500, 'swing');
    }
  });


  $('.navbar-toggler').click(function () {
    if (!$('.navbar-toggler').hasClass('collapsed')) {
      $('#nav').removeClass('bg-transparent');
    }
  })

})();
