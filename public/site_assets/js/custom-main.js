// !function (e) { "use strict"; e("input[name='user_image']").on("change", (function () { !function (i) { if (i.files && i.files[0]) { var s = new FileReader; s.onload = function (i) { e(".fileupload_img").attr("src", i.target.result) }, s.readAsDataURL(i.files[0]) } }(this) })), e("#filter_list,#filter_by_lang,#filter_by_genre").change((function () { var i = e(this).val(); return i && (window.location = i), !1 })), e(window).on("load", (function () { e(".preloader").delay(333).fadeOut("slow"), e("body").delay(333) })), e(".splide").length > 0 && new Splide(".splide", { autoplay: 0, rewind: !0, focus: "center", autoWidth: !0, pauseOnHover: !1, pauseOnFocus: !1, pagination: !1, type: "loop", gap: "1em", padding: { right: "8rem", left: "8rem" }, breakpoints: { 767: { padding: { right: "0rem", left: "0rem" } } } }).mount(), e(".recently-watched-video-carousel").owlCarousel({ nav: !0, margin: 20, navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'], responsive: { 0: { items: 2, slideBy: 2, margin: 15 }, 640: { items: 3, slideBy: 3 }, 768: { items: 4, slideBy: 4 }, 991: { items: 5, slideBy: 5 }, 1198: { items: 6, slideBy: 6 } } }), e(".video-carousel").owlCarousel({ nav: !0, margin: 20, navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'], responsive: { 0: { items: 2, slideBy: 2, margin: 15 }, 480: { items: 3, slideBy: 3 }, 768: { items: 4, slideBy: 4 }, 991: { items: 5, slideBy: 5 }, 1198: { items: 7, slideBy: 7 } } }), e(".video-shows-carousel").owlCarousel({ nav: !0, margin: 20, navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'], responsive: { 0: { items: 1, slideBy: 1 }, 640: { items: 2, slideBy: 2 }, 768: { items: 2, slideBy: 2 }, 991: { items: 3, slideBy: 3 }, 1198: { items: 3, slideBy: 3 } } }), e(".tv-season-video-carousel").owlCarousel({ nav: !0, margin: 20, navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'], responsive: { 0: { items: 2, slideBy: 2, margin: 15 }, 640: { items: 2, slideBy: 2 }, 768: { items: 3, slideBy: 3 }, 991: { items: 4, slideBy: 4 }, 1198: { items: 5, slideBy: 5 } } }), e(".season-item-related").owlCarousel({ nav: !0, margin: 20, navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'], responsive: { 0: { items: 2, slideBy: 2, margin: 15 }, 640: { items: 2, slideBy: 2 }, 768: { items: 4, slideBy: 4 }, 991: { items: 5, slideBy: 5 }, 1198: { items: 6, slideBy: 6 } } }), e(".dropdown-item").click((function (i) { i.preventDefault(), e(".select_season").text(e(this).text()) })); var i = !1; e(".user-menu").on("click", (function (s) { i ? (e(".user-menu ul").css({ opacity: "0", visibility: "hidden" }), i = !1) : (e(".user-menu ul").css({ opacity: "1", visibility: "visible" }), i = !0) })), e("body").click((function (s) { "content-user" !== s.target.className && "user-name" !== s.target.className && "userArrow" !== s.target.id && "userPic" !== s.target.id && (e(".user-menu ul").css({ opacity: "0", visibility: "hidden" }), i = !1) })), e(document).ready((function () { e("select").niceSelect() })), e("body").click((function (s) { "content-user" !== s.target.className && "user-name" !== s.target.className && "userArrow" !== s.target.id && "userPic" !== s.target.id && (e(".user-menu ul").css({ opacity: "0", visibility: "hidden" }), i = !1) })), e(".btn-share").on("click", (function (i) { i.preventDefault(), e("#socialGallery").toggle() })), e(window).on("scroll", (function () { e(window).scrollTop() >= 500 ? e(".scroll-top").fadeIn("slow") : e(".scroll-top").fadeOut("slow") })), e(".scroll-top").on("click", (function () { e("html, body").animate({ scrollTop: 0 }, 800, "easeOutCubic") })), e(".owl-prev").attr("aria-label", "prev"), e(".owl-next").attr("aria-label", "next"), e(".owl-prev").attr("aria-hidden", "true"), e(".owl-next").attr("aria-hidden", "true") }(jQuery);

!function (e) {
    "use strict";
    e("input[name='user_image']").on("change", (function () {
        !function (i) {
            if (i.files && i.files[0]) {
                var s = new FileReader;
                s.onload = function (i) {
                    e(".fileupload_img").attr("src", i.target.result)
                }
                    ,
                    s.readAsDataURL(i.files[0])
            }
        }(this)
    }
    )),
        e("#filter_list,#filter_by_lang,#filter_by_genre").change((function () {
            var i = e(this).val();
            return i && (window.location = i),
                !1
        }
        )),
        e(window).on("load", (function () {
            e(".preloader").delay(333).fadeOut("slow"),
                e("body").delay(333)
        }
        )),
        // e(".splide").length > 0 && new Splide(".splide", {
        //     autoplay: 0,
        //     rewind: !0,
        //     focus: "center",
        //     autoWidth: !0,
        //     pauseOnHover: !1,
        //     pauseOnFocus: !1,
        //     pagination: !1,
        //     type: "loop",
        //     gap: "1em",
        //     padding: {
        //         right: "8rem",
        //         left: "8rem"
        //     },
        //     breakpoints: {
        //         767: {
        //             padding: {
        //                 right: "0rem",
        //                 left: "0rem"
        //             }
        //         }
        //     }
        // }).mount(),
        e(".recently-watched-video-carousel").owlCarousel({
            nav: !0,
            margin: 20,
            loop: false,
            navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 2,
                    slideBy: 2,
                    margin: 15,
                    stagePadding: 50
                },
                640: {
                    items: 3,
                    slideBy: 3,
                    stagePadding: 50
                },
                768: {
                    items: 4,
                    slideBy: 4,
                    stagePadding: 50
                },
                991: {
                    items: 5,
                    slideBy: 5,
                    stagePadding: 50
                },
                1198: {
                    items: 6,
                    slideBy: 6,
                    stagePadding: 50
                }
            }
        }),
        e(".video-carousel").owlCarousel({
            nav: !0,
            margin: 20,
            loop: false,
            navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 2,
                    slideBy: 2,
                    margin: 15,
                    stagePadding: 50
                },
                480: {
                    items: 3,
                    slideBy: 3,
                    stagePadding: 50
                },
                768: {
                    items: 4,
                    slideBy: 4,
                    stagePadding: 50
                },
                991: {
                    items: 5,
                    slideBy: 5,
                    stagePadding: 50
                },
                1198: {
                    items: 7,
                    slideBy: 7,
                    stagePadding: 50
                }
            }
        }),
        e(".video-shows-carousel").owlCarousel({
            nav: !0,
            margin: 20,
            loop: true,
            navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 1,
                    slideBy: 1,
                    stagePadding: 50
                },
                640: {
                    items: 2,
                    slideBy: 2,
                    stagePadding: 50
                },
                768: {
                    items: 2,
                    slideBy: 2,
                    stagePadding: 50
                },
                991: {
                    items: 3,
                    slideBy: 3,
                    stagePadding: 50
                },
                1198: {
                    items: 3,
                    slideBy: 3,
                    stagePadding: 50
                }
            }
        }),
        e(".tv-season-video-carousel").owlCarousel({
            nav: !0,
            margin: 20,
            loop: true,
            navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 2,
                    slideBy: 2,
                    margin: 15,
                    stagePadding: 50
                },
                640: {
                    items: 2,
                    slideBy: 2,
                    stagePadding: 50
                },
                768: {
                    items: 3,
                    slideBy: 3,
                    stagePadding: 50
                },
                991: {
                    items: 4,
                    slideBy: 4,
                    stagePadding: 50
                },
                1198: {
                    items: 6,
                    slideBy: 6,
                    stagePadding: 50
                }
            }
        }),
        e(".season-item-related").owlCarousel({
            nav: !0,
            margin: 30,
            loop: true,
            navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 2,
                    slideBy: 2,
                    margin: 15,
                    stagePadding: 50
                },
                640: {
                    items: 2,
                    slideBy: 2,
                    stagePadding: 50
                },
                768: {
                    items: 4,
                    slideBy: 4,
                    stagePadding: 50
                },
                991: {
                    items: 5,
                    slideBy: 5,
                    stagePadding: 50
                },
                1198: {
                    items: 4,
                    slideBy: 4,
                    stagePadding: 50
                }
            }
        }),
        e(".dropdown-item").click((function (i) {
            i.preventDefault(),
                e(".select_season").text(e(this).text())
        }
        ));
    var i = !1;
    e(".user-menu").on("click", (function (s) {
        i ? (e(".user-menu ul").css({
            opacity: "0",
            visibility: "hidden"
        }),
            i = !1) : (e(".user-menu ul").css({
                opacity: "1",
                visibility: "visible"
            }),
                i = !0)
    }
    )),
        e("body").click((function (s) {
            "content-user" !== s.target.className && "user-name" !== s.target.className && "userArrow" !== s.target.id && "userPic" !== s.target.id && (e(".user-menu ul").css({
                opacity: "0",
                visibility: "hidden"
            }),
                i = !1)
        }
        )),
        e(document).ready((function () {
            e("select").niceSelect()
        }
        )),
        e("body").click((function (s) {
            "content-user" !== s.target.className && "user-name" !== s.target.className && "userArrow" !== s.target.id && "userPic" !== s.target.id && (e(".user-menu ul").css({
                opacity: "0",
                visibility: "hidden"
            }),
                i = !1)
        }
        )),
        e(".btn-share").on("click", (function (i) {
            i.preventDefault(),
                e("#socialGallery").toggle()
        }
        )),
        e(window).on("scroll", (function () {
            e(window).scrollTop() >= 500 ? e(".scroll-top").fadeIn("slow") : e(".scroll-top").fadeOut("slow")
        }
        )),
        e(".scroll-top").on("click", (function () {
            e("html, body").animate({
                scrollTop: 0
            }, 800, "easeOutCubic")
        }
        )),
        e(".owl-prev").attr("aria-label", "prev"),
        e(".owl-next").attr("aria-label", "next"),
        e(".owl-prev").attr("aria-hidden", "true"),
        e(".owl-next").attr("aria-hidden", "true")
}(jQuery);
