<?php

namespace App\Http\Controllers;

use App\Events\MessageDeliverd;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messages = Message::all();
        return view('messages.index')->with('messages', $messages);
    }

    public function store(Request $request)
    {
        $message = auth()->user()->messages()->create($request->all());
        broadcast(new MessageDeliverd($message->load('user')))->toOthers();
    }
}
