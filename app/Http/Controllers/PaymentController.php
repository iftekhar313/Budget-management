<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;

class PaymentController extends Controller
{
    public function store(Request $request, Participant $participant)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'paid_at' => 'required|date',
        ]);

        $participant->payments()->create($request->only('amount', 'paid_at'));

        return redirect()->route('events.show', $participant->event)->with('success', 'Payment recorded.');
    }
}
