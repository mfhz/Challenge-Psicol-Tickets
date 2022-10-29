<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    /**
     * @param TicketRequest $ticketRequest
     * @return JsonResponse
     */
    public function store(TicketRequest $ticketRequest)
    {
        $ticket = new Ticket($ticketRequest->all());
        $ticket->save();
        return response()->json($ticket, 200);
    }
}
