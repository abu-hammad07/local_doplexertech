var slider_customize = function () {
    var values = {
        splider: {},
        values: null,
        current_video: null,
        loading_icon: null,
        init: function () {
            values.splider = new Splide('.splide', {
                autoplay: 0,
                rewind: !0,
                focus: "center",
                autoWidth: !0,
                type: "loop",
                gap: "1em",
                pauseOnHover: false, // Optional: Prevent pause on hover
                resetProgress: false,
                padding: {
                    right: "8rem",
                    left: "8rem"
                },
                breakpoints: {
                    767: {
                        padding: {
                            right: "0rem",
                            left: "0rem"
                        }
                    }
                }
            }).mount();
            values.splider.on('move', function (newIndex, prevIndex, destIndex) {
                if (values.current_video !== null) service.video_pause();
            });
            values.loading_icon = document.querySelector('.loading-icon');
            // service.startInterval();
        }
    }
    //add the events for click buttons
    var add_event = {
        //click description display or not
        show_description: function () {
            $('.btn-description-show').off('click', handle_event.show_description);
            $('.btn-description-show').on('click', handle_event.show_description);
        },
        //click play the video
        play_video: function () {
            $('.play-icon-item').off('click', handle_event.play_video);
            $('.play-icon-item').on('click', handle_event.play_video);

            $('.video-opeation-play').off('click', handle_event.play_video);
            $('.video-opeation-play').on('click', handle_event.play_video);

            $('.splide__slide .video-show video').off('click', handle_event.play_video);
            $('.splide__slide .video-show video').on('click', handle_event.play_video);

            $('.splide__slide .video-show img').off('click', handle_event.play_video);
            $('.splide__slide .video-show img').on('click', handle_event.play_video);
        },
        // click the mute or audi
        audio_video: function () {
            $('.video-opeation-audio').off('click', handle_event.audio_video);
            $('.video-opeation-audio').on('click', handle_event.audio_video);
        },
        //slider-pagination
        slider_bottom_carousel: function () {
            $('.carousel-indicators li').off('click', handle_event.slider_bottom_carousel);
            $('.carousel-indicators li').on('click', handle_event.slider_bottom_carousel);
        },
        //read more or less event
        description_read_more: function () {
            document.querySelector('.movies-info-description-mobile span').removeEventListener('click', handle_event.description_read_more);
            document.querySelector('.movies-info-description-mobile span').addEventListener('click', handle_event.description_read_more);

        },
        video_loading: function () {
            $('video').off('waiting', handle_event.video_waiting);
            $('video').on('waiting', handle_event.video_waiting);

            $('video').off('playing', handle_event.video_playing);
            $('video').on('playing', handle_event.video_playing);

            $('video').off('canplay', handle_event.video_canplay);
            $('video').on('canplay', handle_event.video_canplay);
        },
        init: function () {
            this.show_description();
            this.play_video();
            this.slider_bottom_carousel();
            this.description_read_more();
            this.audio_video();
            this.video_loading();
        }
    }
    //handle the events for click buttons
    var handle_event = {
        //handle description display or not
        show_description: function (event) {
            var $target = $(event.currentTarget);
            if ($target.is(event.target)) {
                if (service.getWindowWidth() <= 456) {
                    var video_id = $target.attr('video-id');

                    var mobile_description = document.querySelector('.movies-info-description-mobile');

                    if (mobile_description.style.display === 'block') {
                        mobile_description.style.display = 'none';
                        if (mobile_description.querySelector('span').innerText === 'Read Less') {
                            mobile_description.querySelector('span').innerText = "Read More";
                            document.querySelector('.movies-info-description-mobile p').classList.add('more')
                        }
                        service.startInterval();
                    } else {
                        mobile_description.style.display = 'block';
                        mobile_description.querySelector('h3').innerText = document.querySelector(`[video-id="${video_id}"] .movies-info-header h1`).innerText;
                        mobile_description.querySelector('p').innerText = document.querySelector(`[video-id="${video_id}"] .movies-info-description p`).innerText;
                        service.pauseInterval();
                    }
                } else {
                    var video_id = $target.attr('video-id');
                    var $descriptionElement = $(`[video-id="${video_id}"] .movies-info-description`);
                    if ($descriptionElement.length) {
                        $descriptionElement.toggleClass('d-flex');
                    }
                }
            }


        },
        // handle the mute or audi
        audio_video: function (event) {
            var $target = $(event.currentTarget);
            var video_id = $target.attr('video-id');
            var video = null;
            var parent = $target[0]; // Get the DOM element from jQuery object

            while (parent) {
                if (parent.tagName === 'LI' && parent.getAttribute('video-id') === video_id) {
                    video = parent.querySelector('video');
                    break;
                }
                parent = parent.parentElement; // Move up to the parent element
            }

            if (video) {
                video.muted = !video.muted;
                parent.querySelector('.video-opeation-audio i').className = video.muted ? 'fas fa-volume-mute' : 'fas fa-volume-up';
            }
        },
        //handle play the video
        play_video: function (event) {
            var $target = $(event.currentTarget);
            var video = null;
            var parent = $target[0]; // Get the DOM element from jQuery object

            while (parent) {
                if (parent.tagName === 'LI') {
                    video = parent.querySelector('video');
                    values.current_video = parent;
                    break;
                }
                parent = parent.parentElement; // Move up to the parent element
            }
            if (video) {
                if (video.paused || video.ended) {
                    video.play();
                    service.pauseInterval();
                    parent.querySelector('.play-icon-item').classList.add('d-none');
                    parent.querySelector('video').classList.remove('d-none');
                    parent.querySelector('.video-operation').classList.remove('d-none');
                    // parent.querySelector('.video-operation').querySelector('span').innerHTML = '<i class="icon fa fa-pause"></i>';
                    parent.querySelector('img').classList.add('d-none');
                } else {
                    video.pause();
                    parent.querySelector('.play-icon-item').classList.remove('d-none');
                    values.current_video = null;
                    // $target.html('<i class="icon fa fa-play"></i>');

                    parent.querySelector('video').classList.add('d-none');
                    parent.querySelector('.video-operation').classList.add('d-none');
                    // parent.querySelector('.video-operation').querySelector('span').innerHTML = '<i class="icon fa fa-play"></i>';

                    parent.querySelector('img').classList.remove('d-none');

                    service.startInterval();
                }
            } else {
                console.log('Video element not found in the ancestor with video-id="' + video_id + '".');
            }

        },
        //handle the carousel event
        slider_bottom_carousel: function (event) {
            event.target.parentElement.querySelector('.active').classList.remove('active');
            event.target.classList.add('active');

            var data_target = event.target.getAttribute('data-target');

            var data_target = document.querySelector(data_target);

            var current_slider = data_target.querySelector('.is-active.is-visible');
            current_slider.classList.remove('is-active', 'is-visible');
            current_slider.setAttribute('aria-hidden', 'true');
            current_slider.setAttribute('tabindex', '-1');

            current_slider = data_target.querySelectorAll(`.splide__slide[slider-id="${event.target.getAttribute('data-slide-to')}"]`)[2];

            current_slider.classList.add('is-active', 'is-visible');

            current_slider.setAttribute('aria-hidden', 'false');
            current_slider.setAttribute('tabindex', '0');

            console.log(data_target, current_slider);
        },
        //handle the description show more or less on mobile device
        description_read_more: function () {
            var current_button = document.querySelector('.movies-info-description-mobile span');
            if (current_button.innerText === 'Read More') {
                current_button.innerText = 'Read Less';
                document.querySelector('.movies-info-description-mobile p').classList.remove('more');
            } else {
                current_button.innerText = 'Read More';
                document.querySelector('.movies-info-description-mobile p').classList.add('more');
            }
        },
        video_waiting: function () {
            values.loading_icon.style.display = 'block';
        },
        video_playing: function () {
            values.loading_icon.style.display = 'none';
        },
        video_canplay: function () {
            values.loading_icon.style.display = 'none';
        }
    }

    var service = {
        //get the device width 
        getWindowWidth: function () {
            return window.innerWidth;
        },
        startInterval: function () {
            values.intervalId = setInterval(function () {
                values.splider.go('+1', true);
            }, 5000); // Run every 1 second (1000 milliseconds)
        },

        pauseInterval: function () {
            clearInterval(values.intervalId);
            console.log('Interval paused.');
        },

        resumeInterval: function () {
            service.startInterval();
            console.log('Interval resumed.');
        },

        video_pause: function () {
            values.current_video.querySelector('.play-icon-item').innerHTML = '<i class="icon fa fa-play"></i>';
            values.current_video.querySelector('video').pause();
            values.current_video.querySelector('video').classList.add('d-none');
            values.current_video.querySelector('.video-operation').classList.add('d-none');
            // parent.querySelector('.video-operation').querySelector('span').innerHTML = '<i class="icon fa fa-play"></i>';

            values.current_video.querySelector('img').classList.remove('d-none');
        },
        isHlsUrl: function (url) {
            // HLS URLs usually end with .m3u8
            return url.toLowerCase().endsWith('.m3u8');
        },
        video_load_hls: function () {
            var videos = document.querySelectorAll('.splide video');
            videos.forEach(video => {
                if (Hls.isSupported() && service.isHlsUrl(video.src)) {
                    const hls = new Hls();
                    hls.loadSource(video.src);
                    hls.attachMedia(video);
                    hls.on(Hls.Events.MANIFEST_PARSED, function () {
                        console.log('you can play the video');
                    });

                    hls.on(Hls.Events.ERROR, function (event, data) {
                        if (data.fatal) {
                            switch (data.type) {
                                case Hls.ErrorTypes.NETWORK_ERROR:
                                    console.error("Network error encountered:", data);
                                    break;
                                case Hls.ErrorTypes.MEDIA_ERROR:
                                    console.error("Media error encountered:", data);
                                    break;
                                default:
                                    console.error("An error occurred:", data);
                                    break;
                            }
                        }
                    });
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    video.addEventListener('loadedmetadata', function () {
                        console.log('you can play the video');
                    });
                } else {
                    console.error('This browser does not support HLS.');
                }
            });
        }
    }
    //some services
    return {
        init: function () {
            values.init();
            add_event.init();
            service.video_load_hls();
        },
        start_slider: function () {
            service.startInterval();
        },
        stop_slider: function () {
            service.pauseInterval();
        }
    }
}();

$(document).ready(function () {
    slider_customize.init();
})
