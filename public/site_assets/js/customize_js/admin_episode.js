var episode_manage = function () {
    var add_event = {
        single_state_change: function () {
            document.querySelector('#single_state[tag-role="choose-single-state"]').removeAttribute('change', handle_event.single_state_change);
            document.querySelector('#single_state[tag-role="choose-single-state"]').addEventListener('change', handle_event.single_state_change);
        },
        init: function () {
            this.single_state_change();
        }
    }

    var handle_event = {
        single_state_change: function () {
            if (document.querySelector('#single_state[tag-role="choose-single-state"]').value === 'single') {
                document.querySelector('[tag-role="seasons-choose"]').classList.add('d-none');
                document.querySelector('[tag-role="seasons-choose"] select').removeAttribute('required');
            }
            else {
                document.querySelector('[tag-role="seasons-choose"]').classList.remove('d-none');
                document.querySelector('[tag-role="seasons-choose"] select').setAttribute('required', '');
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
    episode_manage.init();
})