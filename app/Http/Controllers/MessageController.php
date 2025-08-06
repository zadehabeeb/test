<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class MessageController extends Controller
{


     
    // Store the message and broadcast it
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        // Create the message
        $message = Message::create([
            'sender_id' => $validated['sender_id'],
            'receiver_id' => $validated['receiver_id'],
            'content' => $validated['content'],
        ]);

        // Broadcast the message
        broadcast(new MessageSent($message));

        return response()->json($message, 201);
    }
}
