<?php

namespace App\Http\Controllers;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
  


public function store(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:messages,id'
    ]);

    Message::create([
        'message' => $request->message,
        'user_id' => auth()->id(),
        'parent_id' => $request->parent_id
    ]);

    return back();
}
}
