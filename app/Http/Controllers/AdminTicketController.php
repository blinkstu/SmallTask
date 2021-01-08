<?php

namespace App\Http\Controllers;

use App\Message;
use App\Ticket;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
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
     * list all requests
     */
    public function index(Request $request)
    {
        $tickets = Ticket::with(['user', 'messages'])->orderBy('updated_at', 'desc')->get();
        return response()->json($tickets);
    }

    /**
     * Get one Ticket Details
     */
    public function show(Request $request, $id)
    {
        $ticket = Ticket::with(['user', 'messages'])->where('id', $id)->first();
        if (!$ticket) {
            return response()->json(['error' => 'not found'], 404);
        }
        return response()->json($ticket);
    }

    /**
     * Reply to one Ticket
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $ticket->status = 1;
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
