<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_time', 'desc')->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /** Return events for FullCalendar */
    public function json()
    {
        $events = Event::all()->map(function($e){
            return [
                'id' => $e->id,
                'title' => $e->title,
                'start' => $e->start_time?->toIso8601String(),
                'end' => $e->end_time?->toIso8601String(),
            ];
        });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:1000',
            'event_date' => 'required|date_format:Y-m-d',
        ]);

        // Create event with date at 00:00:00 Bangkok time
        $event = Event::create([
            'title' => $request->title,
            'start_time' => \Carbon\Carbon::createFromFormat('Y-m-d', $request->event_date, 'Asia/Bangkok')->startOfDay()->utc(),
            'end_time' => null,
        ]);

        if ($request->wantsJson()) {
            return response()->json($event, 201);
        }

        return redirect()->route('events.index')->with('success', 'บันทึกกิจกรรมเรียบร้อย');
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:1000',
            'event_date' => 'required|date_format:Y-m-d',
        ]);

        // Update event with date at 00:00:00 Bangkok time
        $event->update([
            'title' => $request->title,
            'start_time' => \Carbon\Carbon::createFromFormat('Y-m-d', $request->event_date, 'Asia/Bangkok')->startOfDay()->utc(),
        ]);

        if ($request->wantsJson()) {
            return response()->json($event);
        }

        return redirect()->route('events.index')->with('success', 'อัพเดตกิจกรรมเรียบร้อย');
    }

    public function destroy(Request $request, Event $event)
    {
        $event->delete();

        if ($request->wantsJson()) {
            return response()->json(['status' => 'deleted']);
        }

        return redirect()->route('events.index')->with('success', 'ลบกิจกรรมเรียบร้อย');
    }
}
