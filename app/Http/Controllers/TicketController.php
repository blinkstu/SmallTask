<?php

namespace App\Http\Controllers;

use App\Message;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;

class TicketController extends Controller
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
     * list user's requests
     */
    public function index(Request $request)
    {
        $tickets = Ticket::with(['user', 'messages'])->where('user_id', $request->user->id)->orderBy('id', 'desc')->get();

        return response()->json($tickets);
    }

    /**
     * Get one Ticket Details
     */
    public function show(Request $request, $id)
    {
        $ticket = Ticket::with(['user', 'messages'])->where('user_id', $request->user->id)->where('id', $id)->first();

        if (!$ticket) {
            return response()->json(['error' => 'not found'], 404);
        }

        return response()->json($ticket);
    }

    /**
     * Create new Ticket
     */
    public function store(Request $request)
    {

        $ticket = new Ticket;
        $ticket->theme = $request->input('theme');
        $ticket->user_id = $request->user->id;
        $ticket->status = 0;
        $ticket->save();

        $message = new Message;
        $message->user_id = $request->user->id;
        $message->content = $request->input('content');

        $ticket->messages()->save($message);

        return response()->json([
            'msg' => 'Success!'
        ]);
    }
}
