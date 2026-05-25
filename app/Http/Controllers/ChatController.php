<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function fetchMessages(Request $request, $userId = null)
    {
        $targetUserId = Auth::user()->role === 'admin' ? $userId : Auth::id();

        if (!$targetUserId) {
            return response()->json([]);
        }

        return Message::where('user_id', $targetUserId)->orderBy('created_at', 'asc')->get();
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['content' => 'required|string']);

        $targetUserId = Auth::user()->role === 'admin' ? $request->user_id : Auth::id();
        $isAdmin = Auth::user()->role === 'admin';

        $message = Message::create([
            'user_id' => $targetUserId,
            'is_admin' => $isAdmin,
            'content' => $request->content,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
