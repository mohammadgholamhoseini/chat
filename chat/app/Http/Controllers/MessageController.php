<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function message()
    {
        $message = Message::with(['user'])->get();
        return response()->json($message);
    }

    public function store(Request $request)
    {
        $message = $request->user()->messages()->create([
            'body' => $request->body
        ]);

        broadcast(new MessageCreated($message))
            ->toOthers();

        return response()->json($message);
    }
}
