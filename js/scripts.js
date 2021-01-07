// Get the current year for the copyright
$('#year').text(new Date().getFullYear());

//Init Scrollspy
$('body').scrollspy({ target: '#main-nav' });

//Smooth Scrolling
$('#main-nav a').on('click', function (event) {
  var navbarNav = $('.navbar-nav');
  var navItems = $('.nav-item');
  if (this.hash !== '') {
    event.preventDefault();
    const hash = this.hash;

    $('html, body').animate(
      {
        scrollTop: $(hash).offset().top,
      },
      800,
      function () {
        window.location.hash = hash;
      }
    );
    navItems.removeClass('active');
    $(this).parent().addClass('active');
  }
});

$(document).ready(function () {
  $('.third-button').on('click', function () {
    $('.animated-icon').toggleClass('open');
  });
  //Collapse buttom
  $('.nav-link').on('click', function () {
    $('.navbar-collapse').collapse('hide');
    $('.animated-icon').toggleClass('open');
  });
});

//Go down button
$(document).ready(function () {
  var scrollLink = $('.scroll');
  // Smooth scrolling
  scrollLink.click(function (e) {
    e.preventDefault();
    $('body, html').animate(
      {
        scrollTop: $(this.hash).offset().top,
      },
      900
    );
  });
});

// Go up button

var btn = $('#up-arrow');

$(window).scroll(function () {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function (e) {
  e.preventDefault();
  $('html, body').animate({ scrollTop: 0 }, '100');
});
