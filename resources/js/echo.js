import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const scheme = import.meta.env.VITE_REVERB_SCHEME || 'http';
const isSecure = scheme === 'https';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
    wsPort: Number(import.meta.env.VITE_REVERB_PORT || (isSecure ? 443 : 80)),
    wssPort: Number(import.meta.env.VITE_REVERB_PORT || 443),
    forceTLS: isSecure,
    enabledTransports: ['ws', 'wss'],
});
