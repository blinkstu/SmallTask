<?php

namespace App\Http\Controllers;

use App\Message;
use App\Ticket;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt_auth');
    }

    /**
     * list messages of that ticket
     */
    public function index(Request $request, $id)
    {
        $messages = Message::with(['user'])->where('user_id', $request->user->id)->where('ticket_id', $id)->orderBy('id', 'desc')->get();

        return response()->json($messages);
    }

    /**
     * Create new message of that ticket
     */
    public function store(Request $request, $id)
    {
        $ticket = Ticket::where('user_id', $request->user->id)->where('user_id', $request->user->id)->where('id', $id)->first();

        $message = new Message;
        $message->user_id = $request->user->id;
        $message->content = $request->input('content');

        $ticket->messages()->save($message);

        return response()->json([
            'msg' => 'Success!'
        ]);
    }
}
