var admin_movie_manage = function () {
    var add_event = {
        //video access change
        video_access_change: function () {
            document.querySelector('#video_access[tag-role="choose-video-access"]').removeEventListener('change', handle_event.video_access_change);
            document.querySelector('#video_access[tag-role="choose-video-access"]').addEventListener('change', handle_event.video_access_change);
        },
        init: function () {
            this.video_access_change();
        }
    }

    var handle_event = {
        //video access change
        video_access_change: function () {
            if (document.querySelector('#video_access[tag-role="choose-video-access"]').value === 'Paid') {
                document.querySelector('[tag-role="set-freetime"]').classList.remove('d-none');
                document.querySelector('[tag-role="set-freetime"] input').setAttribute('required', '');
            } else {
                document.querySelector('[tag-role="set-freetime"]').classList.add('d-none');
                document.querySelector('[tag-role="set-freetime"] input').removeAttribute('required');
            }
        },
    }


    return {
        init: function () {
            add_event.init();
        }
    }
}();

$(document).ready(function () {
    admin_movie_manage.init();
})
