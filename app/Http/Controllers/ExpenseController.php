<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class ExpenseController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
        ]);

        $event->expenses()->create($request->only('category', 'description', 'amount', 'expense_date'));

        return redirect()->route('events.show', $event)->with('success', 'Expense added.');
    }
}
