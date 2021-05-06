/**
 * Drawer menu
 */
$(function () {
  $(".drawer").drawer();
});

/**
 * Smooth scroll
 */
$(function () {
  $('a[href^="#"]').click(function () {
    var speed = 500;
    var href = $(this).attr("href");
    var target = $(href == "#" || href == "" ? "html" : href);
    var position = target.offset().top;
    $("html, body").animate(
      {
        scrollTop: position,
      },
      speed,
      "swing"
    );
    return false;
  });
});

/**
 * Floating btn
 */
$(function () {
  var btn = $(".floating-btn, .floating-bnr");
  $(window).on("scroll ready", function () {
    if ($(this).scrollTop() > 100) {
      btn.fadeIn();
    } else {
      btn.fadeOut();
    }
  });
});

/**
 *  Config
 */
$(function () {
  setTimeout(function () {
    $("body").stop().animate(
      {
        opacity: "1",
      },
      1000
    );
  }, 500);
});

window.addEventListener("load", () => {
  quicklink.listen();
});

new WOW().init();
