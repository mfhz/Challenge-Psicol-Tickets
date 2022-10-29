<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $event = Event::with('tickets')->get();
        return response()->json($event, 200);
    }

    /**
     * @param EventRequest $eventRequest
     * @return JsonResponse
     */
    public function store(EventRequest $eventRequest)
    {
        $event = new Event($eventRequest->all());
        $event->save();

        return response()->json($event, 200);
    }

    /**
     * @param Event $event
     * @return JsonResponse
     */
    public function show($id)
    {
        $event = Event::with('tickets')->find($id);
        return response()->json($event);
    }

    /**
     * @param Event $event
     * @return JsonResponse
     */
    public function destroy(Event $event)
    {
        Event::destroy($event);

        return response()->json('event deleted', 200);
    }

    /**
     * @param EventRequest $eventRequest
     * @param Event $event
     * @return JsonResponse
     */
    public function update(EventRequest $eventRequest, Event $event)
    {
        $event = Event::find($event)->update($eventRequest->all());
        return response()->json($event, 200);
    }
}
