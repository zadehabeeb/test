<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Chat</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>Public Chat</h1>

    <div id="messages"></div>

    <input type="text" id="content" placeholder="Type a message">
    <button onclick="sendMessage()">Send</button>

    <script>
        // Initialize Pusher
        Pusher.logToConsole = true;
        var pusher = new Pusher('0703239b9cfe031d21ef', {
            cluster: 'ap2'
        });

        // Subscribe to the chat channel
        var channel = pusher.subscribe('chat.1'); // Replace 1 with the receiver's user ID

        // Listen for new messages
        channel.bind('App\\Events\\MessageSent', function(data) {
            var messageElement = document.createElement('div');
            messageElement.textContent = data.sender + ": " + data.content;
            document.getElementById('messages').appendChild(messageElement);
        });

        // Send a message
        function sendMessage() {
            var content = document.getElementById('content').value;

            axios.post('/message', {
                sender_id: 1, // Example sender ID
                receiver_id: 2, // Example receiver ID
                content: content
            })
            .then(function(response) {
                document.getElementById('content').value = ''; // Clear input field
            })
            .catch(function(error) {
                console.log(error);
            // });''
        }
    </script>
</body>
</html>
