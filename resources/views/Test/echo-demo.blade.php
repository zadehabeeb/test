<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
    <script>
        function joinPublicChannel() {
        }

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <!-- Use the correct Echo CDN -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>

    <script>
        // Ensure CSRF token is set
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log("initial pusher");

        // Initialize Echo with Pusher
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ config('broadcasting.connections.pusher.key') }}',
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        });

        // Monitor Pusher connection
        Echo.connector.pusher.connection.bind('connected', function() {
            console.log('Pusher connected');
        });

        // Monitor Pusher disconnection
        Echo.connector.pusher.connection.bind('disconnected', function() {
            console.log('Pusher disconnected');
        });

        // Monitor Pusher error
        Echo.connector.pusher.connection.bind('error', function(error) {
            console.error('Pusher error:', error);
        });
    </script>
</body>
</html>
