import './bootstrap';

import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Alpine = Alpine;
window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.PUSHER_APP_KEY,
    cluster: process.env.PUSHER_APP_CLUSTER,
    encrypted: true
});
Echo.channel('chat.' + receiverId) // Listen to the receiver's channel
    .listen('MessageSent', (event) => {
        // Handle the received message
        console.log(event.sender, event.content);
        // Display the message on the frontend
    });

Alpine.start();
