@extends('backend.layout.master')

@push('css')
<!-- You can add specific CSS files here -->
@endpush

@section('content')
<div class="chat-wrapper">
    <div class="chat-sidebar">
        <div class="chat-sidebar-content">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-Chats">
                    <div class="p-3">
                        <!-- Chat list will be populated dynamically via AJAX -->
                        <div class="chat-list" id="userList"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Footer and Message Input -->
    <div class="chat-footer d-flex align-items-center">
        <div class="flex-grow-1 pe-2">
            <div class="input-group">
                <span class="input-group-text"><i class='bx bx-smile'></i></span>
                <input type="text" class="form-control" placeholder="Type a message" id="messageInput">
            </div>
        </div>
        <div class="chat-footer-menu">
            <a href="javascript:;" onclick="sendMessage()"><i class='bx bx-send'></i></a>
        </div>
    </div>

    <!-- Chat Overlay -->
    <div class="overlay chat-toggle-btn-mobile"></div>
</div>

@endsection

@push('script')
<!-- Include jQuery if it's not included already -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Function to load users via AJAX
    $(document).ready(function() {
        loadUsers();
    });

    function loadUsers() {
        $.ajax({
            url: '{{ route("get.users") }}',
            method: 'GET',
            success: function(data) {
                let usersList = '';
                data.forEach(function(user) {
                    usersList += `
                        <a href="javascript:;" class="list-group-item" onclick="openChat(${user.id}, '${user.name}')">
                            <div class="d-flex">
                                <div class="chat-user-online">
                                    <img src="${user.avatar ? user.avatar : 'assets/images/avatars/avatar-1.png'}" width="42" height="42" class="rounded-circle" alt="" />
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0 chat-title">${user.name}</h6>
                                    <p class="mb-0 chat-msg">No new messages</p>
                                </div>
                                <div class="chat-time">${user.created_at}</div>
                            </div>
                        </a>
                    `;
                });
                $('#userList').html(usersList); // Update the chat list
            },
            error: function(err) {
                console.log("Error fetching users: ", err);
            }
        });
    }

    // Function to open the chat when a user is clicked
    function openChat(userId, userName) {
        $.ajax({
            url: '/user-chat/' + userId,
            method: 'GET',
            success: function(response) {
                $('.chat-header h4').text(response.user.name); // Set user name in chat header

                let chatMessages = '';
                response.messages.forEach(function(message) {
                    let messageHtml = `
                        <div class="chat-content-leftside">
                            <div class="d-flex">
                                <img src="${message.user.avatar}" width="48" height="48" class="rounded-circle" alt="" />
                                <div class="flex-grow-1 ms-2">
                                    <p class="mb-0 chat-time">${message.user.name}, ${message.created_at}</p>
                                    <p class="chat-left-msg">${message.content}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    chatMessages += messageHtml;
                });

                $('.chat-content').html(chatMessages); // Update chat content
                scrollToBottom(); // Scroll to the bottom of chat window
            },
            error: function(err) {
                console.log("Error loading chat:", err);
            }
        });

        // Show the chat wrapper
        $('.chat-wrapper').show();
    }

    // Function to send a new message
    function sendMessage() {
        const messageContent = $('#messageInput').val();
        if (messageContent.trim() === '') return; // Don't send empty messages

        $.ajax({
            url: '/send-message', 
            method: 'POST',
            data: {
                user_id: userId,  // The current user ID
                message: messageContent,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                const newMessageHtml = `
                    <div class="chat-content-rightside">
                        <div class="d-flex ms-auto">
                            <div class="flex-grow-1 me-2">
                                <p class="mb-0 chat-time text-end">You, ${response.created_at}</p>
                                <p class="chat-right-msg">${response.message}</p>
                            </div>
                        </div>
                    </div>
                `;
                $('.chat-content').append(newMessageHtml); // Append the new message
                $('#messageInput').val(''); // Clear the input field
                scrollToBottom(); // Scroll to the bottom
            },
            error: function(err) {
                console.log("Error sending message:", err);
            }
        });
    }

    // Function to scroll chat content to the bottom
    function scrollToBottom() {
        $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight);
    }
</script>
@endpush
