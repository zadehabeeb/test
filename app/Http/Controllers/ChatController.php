<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Message; 


use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display the chat interface.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
         $users = User::all();
        return view('backend.chat.index', compact('users'));
        // return view('backend.chat.index');
    }
     public function getChatHistory(User $user)
    {
        // Retrieve the chat history of the current user, for example, the last 20 messages
        $messages = Message::where('user_id', $user->id)
                            ->orWhere('receiver_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->take(20)
                            ->get();

        return response()->json([
            'user' => $user,
            'messages' => $messages,
        ]);
    }
    public function sendMessage(Request $request)
{
    // Validate the message input
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'message' => 'required|string',
    ]);

    // Store the message in the database
    $message = Message::create([
        'user_id' => auth()->id(),  // Assuming the authenticated user is sending the message
        'receiver_id' => $request->user_id,
        'content' => $request->message,
    ]);

    // Return the new message as a response
    return response()->json([
        'message' => $message->content,
        'created_at' => $message->created_at->format('h:i A'),
    ]);
}

}
