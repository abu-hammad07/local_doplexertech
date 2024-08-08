// !function(e){"use strict";if(e(".top-bar").length>0)var s=e(".top-bar").height();else s=0;e(".vfx-item-nav li a").click((function(){e(this).parent().hasClass("hover")?e(this).parent().removeClass("hover"):e(this).parent().addClass("hover")})),e(".vfx-item-nav li span.arrow").click((function(){e(this).parent().hasClass("hover")?e(this).parent().removeClass("hover"):e(this).parent().addClass("hover")})),e(".search-parent > a").click((function(){e(this).parent().hasClass("active")?e(this).parent().removeClass("active"):e(this).parent().addClass("active"),e(".cart-parent").removeClass("active"),e("#menu").removeClass("in")})),e(".cart-parent > a").click((function(){e(this).parent().hasClass("active")?e(this).parent().removeClass("active"):e(this).parent().addClass("active"),e(".search-parent").removeClass("active"),e("#menu").removeClass("in")})),e(".close-btn").click((function(){e(".search-parent").removeClass("active"),e("#menu li").removeClass("hover"),e(".cart-parent").removeClass("active")})),e(".menu-icon").click((function(){e(".search-parent").removeClass("active"),e(".cart-parent").removeClass("active")})),e("#menu li").click((function(){e(window).width()<1001&&(e(".search-parent").removeClass("active"),e(".cart-parent").removeClass("active"))}));var a=0;e(window).scroll((function(){e(window).width()>1e3?(e(window).scrollTop()>200+s?e(".header-section").removeAttr("style").addClass("pin"):e(".header-section").css({top:-e(window).scrollTop()}).removeClass("pin"),e(window).scrollTop()>150+s?e(".header-section").addClass("before"):e(".header-section").removeClass("before")):e(window).scrollTop()<a&&(e(".header-section").addClass("off").removeClass("woff").removeAttr("style"),e("#menu").removeClass("in"),e(".search-parent").removeClass("active"),e(".cart-parent").removeClass("active"),a=0),e(window).scrollTop()>s?e(".header-section").hasClass("woff")||e(".header-section").addClass("pin-start").addClass("off"):e(".header-section").removeClass("pin-start").removeClass("off")})),e(window).scrollTop()>150+s?e(".header-section").addClass("pin"):e(".header-section").removeAttr("style").removeClass("pin"),e(window).resize((function(){e(window).width()>1e3&&e(".header-section").removeAttr("style")})),e(window).scrollTop()>s?e(".header-section").addClass("off").addClass("pin-start"):e(".header-section").removeClass("off").removeClass("pin-start"),e(".menu-icon").click((function(){e("#menu").hasClass("in")?(e(".header-section").addClass("off").removeClass("woff").removeAttr("style"),e(window).scrollTop()>s?e(".header-section").hasClass("woff")||e(".header-section").addClass("pin-start").addClass("off"):e(".header-section").removeClass("pin-start").removeClass("off")):(a=e(window).scrollTop(),e(".header-section").removeClass("off").addClass("woff").css({top:e(window).scrollTop()}))})),e(".cart-parent >a").click((function(){e(window).width()<1001&&(e(".cart-parent").hasClass("active")?(a=e(window).scrollTop(),e(".header-section").removeClass("off").addClass("woff").css({top:e(window).scrollTop()})):(e(".header-section").addClass("off").removeClass("woff").removeAttr("style"),e(window).scrollTop()>s?e(".header-section").hasClass("woff")||e(".header-section").addClass("pin-start").addClass("off"):e(".header-section").removeClass("pin-start").removeClass("off")))})),e(".search-parent >a").click((function(){e(window).width()<1001&&(e(".search-parent").hasClass("active")?(a=e(window).scrollTop(),e(".header-section").removeClass("off").addClass("woff").css({top:e(window).scrollTop()})):(e(".header-section").addClass("off").removeClass("woff").removeAttr("style"),e(window).scrollTop()>s?e(".header-section").hasClass("woff")||e(".header-section").addClass("pin-start").addClass("off"):e(".header-section").removeClass("pin-start").removeClass("off")))}))}(jQuery);
(function ($) {
    "use strict";

    // Calculate top bar height
    var s = $(".top-bar").length > 0 ? $(".top-bar").height() : 0;

    // Toggle 'hover' class on navigation items
    $(".vfx-item-nav li a, .vfx-item-nav li span.arrow").click(function () {
        $(this).parent().toggleClass("hover");
    });

    // Toggle 'active' class on search and cart sections
    $(".search-parent > a, .cart-parent > a").click(function () {
        var parentClass = $(this).parent().hasClass("search-parent") ? ".search-parent" : ".cart-parent";
        $(this).parent().toggleClass("active");
        $(parentClass === ".search-parent" ? ".cart-parent" : ".search-parent").removeClass("active");
        $("#menu").removeClass("in");
    });

    // Close button interaction
    $(".close-btn").click(function () {
        $(".search-parent, .cart-parent").removeClass("active");
        $("#menu li").removeClass("hover");
    });

    // Menu icon interaction
    $(".menu-icon").click(function () {
        $(".search-parent, .cart-parent").removeClass("active");
    });

    // Variable to store the scroll position
    var a = 0;

    // Adjust header behavior on scroll
    $(window).scroll(function () {
        if ($(window).width() > 1000) {
            if ($(window).scrollTop() > 200 + s) {
                $(".header-section").removeAttr("style").addClass("pin");
            } else {
                $(".header-section").css({ top: -$(window).scrollTop() }).removeClass("pin");
            }

            if ($(window).scrollTop() > 150 + s) {
                $(".header-section").addClass("before");
            } else {
                $(".header-section").removeClass("before");
            }
        } else {
            if ($(window).scrollTop() < a) {
                $(".header-section").addClass("off").removeClass("woff").removeAttr("style");
                $("#menu").removeClass("in");
                $(".search-parent, .cart-parent").removeClass("active");
                a = 0;
            }
        }

        if ($(window).scrollTop() > s) {
            $(".header-section").addClass("pin-start off");
        } else {
            $(".header-section").removeClass("pin-start off");
        }
    });

    // Initial header setup based on scroll position
    if ($(window).scrollTop() > 150 + s) {
        $(".header-section").addClass("pin");
    } else {
        $(".header-section").removeAttr("style").removeClass("pin");
    }

    // Adjust header on window resize
    $(window).resize(function () {
        if ($(window).width() > 1000) {
            $(".header-section").removeAttr("style");
        }
    });

    // Adjust header based on menu icon click
    $(".menu-icon").click(function () {
        if ($("#menu").hasClass("in")) {
            $(".header-section").addClass("off").removeClass("woff").removeAttr("style");
        } else {
            a = $(window).scrollTop();
            $(".header-section").removeClass("off").addClass("woff").css({ top: $(window).scrollTop() });
        }
    });

    // Adjust header based on cart and search interactions on smaller screens
    $(".cart-parent >a, .search-parent >a").click(function () {
        if ($(window).width() < 1001) {
            var parentClass = $(this).parent().hasClass("cart-parent") ? ".cart-parent" : ".search-parent";
            if ($(this).parent().hasClass("active")) {
                a = $(window).scrollTop();
                $(".header-section").removeClass("off").addClass("woff").css({ top: $(window).scrollTop() });
            } else {
                $(".header-section").addClass("off").removeClass("woff").removeAttr("style");
                if ($(window).scrollTop() > s) {
                    $(".header-section").addClass("pin-start off");
                } else {
                    $(".header-section").removeClass("pin-start off");
                }
            }
        }
    });

})(jQuery);
