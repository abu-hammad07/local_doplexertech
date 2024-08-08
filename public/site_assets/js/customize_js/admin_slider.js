var admin_slider_manager = function () {
    var add_event = {
        //image select option change
        image_select_option: function () {
            document.getElementById('image_input_state').removeEventListener('change', listen_event.image_select_option);
            document.getElementById('image_input_state').addEventListener('change', listen_event.image_select_option);
        },
        //video select option change
        video_select_option: function () {
            document.getElementById('video_input_state').removeEventListener('change', listen_event.video_select_option);
            document.getElementById('video_input_state').addEventListener('change', listen_event.video_select_option);
        },
        init: function () {
            this.image_select_option();
            this.video_select_option();
        }
    }
    var listen_event = {
        //image select option change
        image_select_option: function (event) {
            if (event.target.value == 0) {
                document.getElementById('slider_image_url').classList.remove('d-none');
                document.getElementById('slider_image_file').classList.add('d-none');

                document.getElementById('slider_image_url').setAttribute('required', '');
                document.getElementById('slider_image_file').removeAttribute('required');

            } else {
                document.getElementById('slider_image_url').classList.add('d-none');
                document.getElementById('slider_image_file').classList.remove('d-none');

                document.getElementById('slider_image_url').removeAttribute('required');
                document.getElementById('slider_image_file').setAttribute('required', '');
            }
        },
        //image select option change
        video_select_option: function (event) {
            if (event.target.value == 0) {
                document.getElementById('slider_video_url').classList.remove('d-none');
                document.getElementById('slider_video_file').classList.add('d-none');

                document.getElementById('slider_video_url').setAttribute('required', '');
                document.getElementById('slider_video_file').removeAttribute('required');

            } else {
                document.getElementById('slider_video_url').classList.add('d-none');
                document.getElementById('slider_video_file').classList.remove('d-none');

                document.getElementById('slider_video_url').removeAttribute('required');
                document.getElementById('slider_video_file').setAttribute('required', '');
            }
        }
    }
    return {
        init: function () {
            add_event.init();
        }
    }
}();

$(document).ready(function () {
    admin_slider_manager.init();
})