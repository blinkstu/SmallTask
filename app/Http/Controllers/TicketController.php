<?php

namespace App\Http\Controllers;

use App\Message;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $tickets = Ticket::with(['user', 'messages'])->where('user_id', $request->user->id)->orderBy('updated_at', 'desc')->get();

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
        $validation = Validator::make(request()->all(), [
            'theme'   => 'required',
            'content' => 'required'
        ]);

        $errors = $validation->errors()->all();

        if (count($errors) > 0) {
            return response()->json([
                'error' => $errors[0]
            ], 400);
        }

        $todays_tickets = Ticket::whereDate('created_at', Carbon::today())->where('user_id', $request->user->id)->count();
        if ($todays_tickets >= 1) {
            return response()->json([
                'error' => 'Только одна заявка в день!'
            ], 403);
        }

        $ticket = new Ticket;
        $ticket->theme = $request->input('theme');
        $ticket->user_id = $request->user->id;
        $ticket->status = 0;
        $ticket->save();

        $message = new Message;
        $message->user_id = $request->user->id;
        $message->content = $request->input('content');
        $message->file_id = $request->input('file');

        $ticket->messages()->save($message);

        return response()->json([
            'msg' => 'Success!'
        ]);
    }
}
