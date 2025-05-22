<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class ParticipantController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'expected_contribution' => 'required|numeric|min:0',
        ]);

        $event->participants()->create($request->only('name', 'expected_contribution'));

        return redirect()->route('events.show', $event)->with('success', 'Participant added.');
    }
}
