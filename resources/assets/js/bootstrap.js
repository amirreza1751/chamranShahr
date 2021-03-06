import pusher from "pusher-js";
window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    // key: process.env.MIX_PUSHER_APP_KEY,
    key: 'ABCDEFG',
    // cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    cluster: 'mt1',
    encrypted: true,
    wsHost : window.location.hostname,
    authEndpoint: '/74522B1B45313233CBA723B112A76361D7850AAEA95A5DC67AE9FC072FE1DF1745F22956D3E0AABE373059B65735715EE7DB79AB52A37FD22FE5E64FB288B942/broadcasting/auth',
    wsPort : 6001,
    wssPort: 6001,
    disableStats: false,
    enabledTransports: ['ws', 'wss'],
    auth: {
        headers: {
            // Authorization: 'Bearer ' + window.axios.defaults.headers.common['X-CSRF-TOKEN']
            'X-CSRF-TOKEN': window.axios.defaults.headers.common['X-CSRF-TOKEN'],
        },
    }
});
