<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chatWithUser(Request $request, $recipientId, $senderId)
    {
        // $userId = auth()->id(); // Authenticated user
        // $userId = $request->input('sender_id');
        $userId = $senderId; 
        $user = User::find($userId);

        // Fetch the recipient user data
        $recipient = User::findOrFail($recipientId);

       

        // Check if a chat already exists between the two users
        $chat = Conversation::where(function ($query) use ($userId, $recipientId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $recipientId);
        })->orWhere(function ($query) use ($userId, $recipientId) {
            $query->where('sender_id', $recipientId)
                  ->where('receiver_id', $userId);
        })->first();


        $messages = Message::where(function ($query) use ($userId, $recipientId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $recipientId);
        })
        ->orWhere(function ($query) use ($userId, $recipientId) {
            $query->where('sender_id', $recipientId)
                  ->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get()?? collect();

       

        $chattedUsers = Conversation::getConversationsForSidebar($user);

        return response()->json([
            'recipient' => $recipient, 
                'chattedUsers' => $chattedUsers, 
                'messages' => $messages

        ]);
    }




    public function sendMessage(Request $request)
{
    $userId = Auth::id();
    // The ID of the authenticated user (the sender)
    $user = User::find($userId);
    $recipientId = $request->input('receiver_id'); // The ID of the recipient
    $messageText = $request->input('message'); // The message text

   
    // Step 1: Check if a chat already exists between the two users
    $chat = Conversation::where(function ($query) use ($userId, $recipientId) {
        $query->where('sender_id', $userId)
              ->where('receiver_id', $recipientId);
    })->orWhere(function ($query) use ($userId, $recipientId) {
        $query->where('sender_id', $recipientId)
              ->where('receiver_id', $userId);
    })->first();

    // Step 2: If chat does not exist, create a new one
    if (!$chat) {
        $chat = Conversation::create([
            'sender_id' => $userId,
            'receiver_id' => $recipientId
        ]);
    }

   

    // Step 3: Now, create the new message under the existing or new chat
    $messages = Message::create([
        'sender_id' => $userId,
        'receiver_id' => $recipientId,
        'message' => $messageText
    ]);
   

     // Step 4: Get all users the authenticated user has chatted with
     $chattedUsers = Conversation::getConversationsForSidebar($user);

    return response()->json([
        'messages' => $messages,
        'chattedUsers' => $chattedUsers

    ]);
   
}

}
