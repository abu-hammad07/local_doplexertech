var video_show_manage = function () {
    var values = {
        video: null,
        timeline: null,
        timeline_bar: null,
        timeline_endpoint: null,
        video_loading_icon: null,
        video_volume_value: null,
        video_access_state: null,
        video_free_time: null,

        init: function () {
            values.video = document.querySelector('.video-show .video-show-content video');
            values.timeline = document.querySelector('.video-show .video-show-control .video-show-control-timeline');
            values.timeline_bar = document.querySelector('.video-show .video-show-control-timeline .video-control-timeline-progress');
            values.timeline_endpoint = document.querySelector('.video-show .video-show-control-timeline .video-control-timeline-endpoint');
            values.video_loading_icon = document.getElementById('loadingIcon');
            values.video_volume_value = document.querySelector('.video-show .video-show-control-btns [tag-role="video-volume-slider"]');
            values.video_access_state = document.querySelector('.video-show .video-show-content video').getAttribute('access_status');
            values.video_free_time = document.querySelector('.video-show .video-show-content video').getAttribute('free_time');

            if (document.querySelector('.video-show .video-show-content video').getAttribute('saved_time')) {
                if (values.video.duration > document.querySelector('.video-show .video-show-content video').getAttribute('saved_time')) {
                    values.video.currentTime = document.querySelector('.video-show .video-show-content video').getAttribute('saved_time');
                }
                console.log("Saved Timed: ", document.querySelector('.video-show .video-show-content video').getAttribute('saved_time'));
            }

            if (!isNaN(values.video.duration)) {
                document.querySelector('.video-show .video-show-control-btns [tag-role="video-timer-duration"]').innerText = service.formate_time(values.video.duration);
            }

            document.querySelector('.video-show .video-show-control-btns [tag-role="video-timer-currenttime"]').innerText = service.formate_time(0);
            
            const checkIfReady = setInterval(() => {
                if ( values.video.readyState >= 3) { 
                    clearInterval(checkIfReady);
                    console.log('play video');
                    
                    document.querySelector('.video-show .video-show-control-btns [tag-role="video-timer-duration"]').innerText = service.formate_time(values.video.duration);

                    if (document.querySelector('.video-show .video-show-content video').getAttribute('saved_time')) {
                        if (values.video.duration > document.querySelector('.video-show .video-show-content video').getAttribute('saved_time')) {
                            values.video.currentTime = document.querySelector('.video-show .video-show-content video').getAttribute('saved_time');
                        }
                        console.log("Saved Timed: ", document.querySelector('.video-show .video-show-content video').getAttribute('saved_time'));
                    }
                    
                    values.video_volume_value.value = values.video.volume;
                    
                }
            }, 1000);
        }
    }
    //register the some events
    var addEventListener = {
        // video play when the initial page
        video_play_init: function () {
            document.querySelector('.video-show .video-show-player-btn i').removeEventListener('click', EventListener.video_play_init);
            document.querySelector('.video-show .video-show-player-btn i').addEventListener('click', EventListener.video_play_init);

            document.querySelector('.video-show .video-show-content video').removeEventListener('click', EventListener.video_pause_play);
            document.querySelector('.video-show .video-show-content video').addEventListener('click', EventListener.video_pause_play);
        },
        //video play/pause event when running the video
        video_pause_play: function () {
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-sate"]').removeEventListener('click', EventListener.video_pause_play);
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-sate"]').addEventListener('click', EventListener.video_pause_play);
        },
        //video timeline change as time goes by
        video_timeline_change: function () {
            document.querySelector('.video-show .video-show-content video').removeEventListener('timeupdate', EventListener.video_timeline_change);
            document.querySelector('.video-show .video-show-content video').addEventListener('timeupdate', EventListener.video_timeline_change);
        },
        //click the timeline
        video_timeline_click: function () {
            document.querySelector('.video-show-control .video-show-control-timeline').removeEventListener('click', EventListener.video_timeline_click);
            document.querySelector('.video-show-control .video-show-control-timeline').addEventListener('click', EventListener.video_timeline_click);
        },
        // when video play is ended
        video_ended: function () {
            document.querySelector('.video-show .video-show-content video').removeEventListener('ended', EventListener.video_ended);
            document.querySelector('.video-show .video-show-content video').addEventListener('ended', EventListener.video_ended);
        },
        //video element mute or not
        video_mute_state: function () {
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-mute-state"]').removeEventListener('click', EventListener.video_mute_state);
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-mute-state"]').addEventListener('click', EventListener.video_mute_state);
        },
        video_time_manage: function () {
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-time-forward"]').removeEventListener('click', EventListener.vieo_time_forward);
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-time-forward"]').addEventListener('click', EventListener.vieo_time_forward);

            document.querySelector('.video-show .video-show-control-btns [tag-role="video-time-backward"]').removeEventListener('click', EventListener.vieo_time_backward);
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-time-backward"]').addEventListener('click', EventListener.vieo_time_backward);
        },
        // when video loading and playing display the pre loading icon or not.
        video_loading: function () {
            $('video').off('waiting', EventListener.video_waiting);
            $('video').on('waiting', EventListener.video_waiting);

            $('video').off('playing', EventListener.video_playing);
            $('video').on('playing', EventListener.video_playing);

            $('video').off('canplay', EventListener.video_canplay);
            $('video').on('canplay', EventListener.video_canplay);
        },
        // video screen expand
        video_screen_expand: function () {
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-screen-expand"]').removeEventListener('click', EventListener.vieo_time_backward);
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-screen-expand"]').addEventListener('click', EventListener.video_screen_expand);
        },
        // video volume control
        video_volume_control: function () {
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-volume-slider"]').removeEventListener('input', EventListener.video_volume_control);
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-volume-slider"]').addEventListener('input', EventListener.video_volume_control);
        },
        // show the video descriptoin
        video_description_display: function () {
            document.querySelector('span [tag-role="btn-show-description"]').removeEventListener('click', EventListener.video_description_display);
            document.querySelector('span [tag-role="btn-show-description"]').addEventListener('click', EventListener.video_description_display);
        },
        init: function () {
            this.video_play_init();
            this.video_pause_play();
            this.video_timeline_change();
            this.video_timeline_click();
            this.video_ended();
            this.video_mute_state();
            this.video_time_manage();
            this.video_loading();
            this.video_screen_expand();
            this.video_volume_control();
            this.video_description_display();
        }
    }

    //listen the events
    var EventListener = {
        // video play when the init
        video_play_init: function () {
            document.querySelector('.video-show .video-show-player-btn i').classList.add('d-none');
            document.querySelector('.video-show-content video').play();
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-sate"]').classList.remove('fa-play');
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-sate"]').classList.add('fa-pause');
        },
        //when video ended manage
        video_ended: function () {
            values.video.currentTime = 0;
            values.video.pause();

            document.querySelector('.video-show .video-show-player-btn i').classList.remove('d-none');
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-sate"]').classList.add('fa-play');
            document.querySelector('.video-show .video-show-control-btns [tag-role="video-sate"]').classList.remove('fa-pause');
        },
        //video mute state
        video_mute_state: function () {
            values.video.muted = !values.video.muted;
            if (values.video.muted) {
                document.querySelector('.video-show .video-show-control-btns [tag-role="video-mute-state"]').classList.remove('fa-volume-up');
                document.querySelector('.video-show .video-show-control-btns [tag-role="video-mute-state"]').classList.add('fa-volume-mute');
            } else {
                document.querySelector('.video-show .video-show-control-btns [tag-role="video-mute-state"]').classList.add('fa-volume-up');
                document.querySelector('.video-show .video-show-control-btns [tag-role="video-mute-state"]').classList.remove('fa-volume-mute');
            }
        },
        // video pause or play
        video_pause_play: function () {
            var play_pause_icon = document.querySelector('.video-show .video-show-control-btns [tag-role="video-sate"]');
            if (play_pause_icon.classList.contains('fa-pause')) {
                play_pause_icon.classList.remove('fa-pause');
                play_pause_icon.classList.add('fa-play');
                document.querySelector('.video-show-content video').pause();
            } else {
                play_pause_icon.classList.add('fa-pause');
                play_pause_icon.classList.remove('fa-play');
                EventListener.video_play_init();
            }
        },
        //video time line change as time goes by
        video_timeline_change: function () {
            const percentage = (values.video.currentTime / values.video.duration) * 100;

            document.querySelector('.video-show .video-show-control-btns [tag-role="video-timer-currenttime"]').innerText = service.formate_time(values.video.currentTime);

            values.timeline_bar.style.width = `${percentage}%`;
            values.timeline_endpoint.style.left = `${percentage}%`;

            if (values.video_access_state === 'Paid' && values.video_free_time <= values.video.currentTime) {
                EventListener.video_pause_play();
                values.video.currentTime = values.video_free_time - 1;
                service.fire_limit_watch();
            }
        },
        // video volume control higer or down
        video_volume_control: function () {
            values.video.volume = parseFloat(values.video_volume_value.value);
            if (values.video.muted) {
                EventListener.video_mute_state();
            }
            values.video_volume_value.style.setProperty('--value', (values.video_volume_value.value * 100) + '%');
        },
        // video screen expand functionality
        video_screen_expand: function () {
            if (values.video.requestFullscreen) {
                values.video.requestFullscreen();
            } else if (values.video.mozRequestFullScreen) { // Firefox
                values.video.mozRequestFullScreen();
            } else if (values.video.webkitRequestFullscreen) { // Chrome, Safari and Opera
                values.video.webkitRequestFullscreen();
            } else if (values.video.msRequestFullscreen) { // IE/Edge
                values.video.msRequestFullscreen();
            }
        },
        // click the timeline 
        video_timeline_click: function (e) {
            const timelineWidth = values.timeline.offsetWidth;
            const clickPosition = e.offsetX;

            var newTime = (clickPosition / timelineWidth) * document.getElementById('video-show-content-videotag').duration;

            console.log('Current Time: ', document.getElementById('video-show-content-videotag').currentTime);

            newTime = newTime.toFixed(6);

            console.log('New Time: ', parseFloat(newTime));

            if (document.getElementById('video-show-content-videotag').paused) {
                document.getElementById('video-show-content-videotag').currentTime = newTime;
            }
            else {
                document.getElementById('video-show-content-videotag').pause();
                document.getElementById('video-show-content-videotag').currentTime = newTime;
                document.getElementById('video-show-content-videotag').play();
            }

            console.log("Changed Time: ", values.video.currentTime);
        },
        // timeline backward 10 second and forward (Note: upperside)
        vieo_time_backward: function () {
            values.video.currentTime = (values.video.currentTime + 10) < values.video.duration ? (values.video.currentTime + 10) : values.video.duration;
        },
        vieo_time_forward: function () {
            values.video.currentTime = (values.video.currentTime - 10) > 0 ? (values.video.currentTime - 10) : 0;
        },
        // video descriptoin display
        video_description_display: function () {
            var description_tag = document.querySelector('.video-description-wrapper');
            description_tag.classList.toggle('d-none');
        },
        // loading functionality
        video_waiting: function () {
            values.video_loading_icon.style.display = 'block';
        },
        video_playing: function () {
            values.video_loading_icon.style.display = 'none';
        },
        video_canplay: function () {
            values.video_loading_icon.style.display = 'none';
        }

    }

    var service = {
        //change the time format 02:22
        formate_time: function (time) {
            var minutes = Math.floor(time / 60);
            var seconds = Math.floor(time % 60);

            if (seconds < 10) {
                seconds = '0' + seconds;
            }
            if (minutes < 10) {
                minutes = '0' + minutes;
            }

            var consult = minutes + ':' + seconds;

            return consult;

        },
        fire_limit_watch: function () {
            var html_code = `<div class="d-flex align-items-center justify-content-between gap-5 flex-column">
            <a href="#" title="logo" class="logo logostate" ><img width="100px" src="https://doplexertech.com/upload/site_logo.png" alt="logo" title="logo"></a>
            <p>To keep enjoying ZongFlex please <span style="text-transform: uppercase; font-weight: bold;">subscribe now !</span></p>
            </div>`;

            Swal.fire({
                html: html_code,
                confirmButtonColor: '#FF6506',
                confirmButtonText: 'Continue',
                background: "#1a2234",
                allowOutsideClick: true,
                color: "#fff"
            }).then((result) => {
                if (result.isConfirmed) {
                    var page_url = window.location.pathname;
                    var video_current_time = values.video.currentTime;
                    console.log(page_url, video_current_time);

                    var go_url = `/signup?page_url=${encodeURIComponent(page_url)}&video_current_time=${encodeURIComponent(video_current_time)}`;
                    window.location.href = go_url;
                }
            });
        },
        video_hls_apply: function () {
            const video = document.querySelector('.video-show .video-show-content video');
            if (!video.src.toLowerCase().endsWith('.m3u8')) return;
            if (Hls.isSupported()) {
                const hls = new Hls();
                const video_url = video.src;
                hls.loadSource(video.src);
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, function () {
                    console.log('you can play the video');
                });
                console.log(video.src);
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
                    video.src = video_url;
                });
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.addEventListener('loadedmetadata', function () {
                    console.log('you can play the video');
                });
            } else {
                console.error('This browser does not support HLS.');
            }
        }
    }

    return {
        init: function () {
            values.init();
            service.video_hls_apply();
            addEventListener.init();
        }
    }
}();

$(document).ready(function () {
    video_show_manage.init();
})
