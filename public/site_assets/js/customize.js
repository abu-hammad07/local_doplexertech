var left_banner = function () {
    //add the click event
    var add_event = {
        // show the bannner
        show_banner: function () {
            document.getElementById('leftbanner_show').removeEventListener('click', handle_event.show_banner);
            document.getElementById('leftbanner_show').addEventListener('click', handle_event.show_banner);
        },
        // register all event
        init: function () {
            this.show_banner();
        }
    }
    //handle the click event
    var handle_event = {
        // handle show the bannner
        show_banner: function (event) {
            if (event.currentTarget.getAttribute('show_state') === 'true') {
                event.currentTarget.setAttribute('show_state', 'false');
                event.currentTarget.innerHTML = '<i class="fa fa-bars"></i>';
                document.querySelector('.left-banner').classList.remove('show');
            } else {
                event.currentTarget.innerHTML = '<i class="fas fa-arrow-left"></i>';
                event.currentTarget.setAttribute('show_state', 'true');
                document.querySelector('.left-banner').classList.add('show');
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
    left_banner.init();
})