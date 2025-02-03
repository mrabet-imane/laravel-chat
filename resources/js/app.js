import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;
console.log(import.meta.env.VITE_PUSHER_APP_KEY);
console.log(import.meta.env.VITE_PUSHER_APP_CLUSTER);

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

// Écouter les messages diffusés en temps réel
window.Echo.channel('chat-channel')
    .listen('MessageSent', (event) => {
        console.log('Message reçu:', event.message);
        document.getElementById('chat-box').innerHTML += `<p><strong>${event.user.name}</strong>: ${event.message}</p>`;
        document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;
    });

import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
