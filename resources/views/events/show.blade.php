@extends('layouts.app')

@section('title', $event->name)

@section('content')
<h1 class="text-3xl font-bold mb-6">{{ $event->name }}</h1>

<div class="mb-6">
    <p><strong>Destination:</strong> {{ $event->destination }}</p>
    <p><strong>Date:</strong> {{ $event->date->format('M d, Y') }}</p>
    <p><strong>Budget:</strong> ${{ number_format($event->budget, 2) }}</p>
    <p><strong>Total Contributions:</strong> ${{ number_format($event->total_contributions, 2) }}</p>
    <p><strong>Total Expenses:</strong> ${{ number_format($event->total_expenses, 2) }}</p>
</div>

<hr class="mb-6" />

<!-- Participants Section -->
<h2 class="text-2xl font-semibold mb-4">Participants</h2>

<form method="POST" action="{{ route('participants.store', $event) }}" class="mb-6 max-w-lg bg-white p-4 rounded shadow">
    @csrf
    <div class="mb-4">
        <label class="block mb-1 font-medium">Name</label>
        <input type="text" name="name" required class="w-full border rounded p-2" />
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-medium">Expected Contribution ($)</label>
        <input type="number" step="0.01" name="expected_contribution" required class="w-full border rounded p-2" />
    </div>
    <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">Add Participant</button>
</form>

@if($event->participants->isEmpty())
    <p>No participants yet.</p>
@else
    <table class="min-w-full bg-white rounded shadow mb-6">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 text-left">Name</th>
                <th class="py-2 px-4 text-left">Expected Contribution</th>
                <th class="py-2 px-4 text-left">Total Paid</th>
                <th class="py-2 px-4 text-left">Add Payment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($event->participants as $participant)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ $participant->name }}</td>
                    <td class="py-2 px-4">${{ number_format($participant->expected_contribution, 2) }}</td>
                    <td class="py-2 px-4">${{ number_format($participant->total_paid, 2) }}</td>
                    <td class="py-2 px-4">
                        <form method="POST" action="{{ route('payments.store', $participant) }}" class="flex space-x-2 items-center">
                            @csrf
                            <input type="number" step="0.01" name="amount" placeholder="Amount" required class="border rounded p-1 w-24" />
                            <input type="date" name="paid_at" required class="border rounded p-1" />
                            <button type="submit" class="bg-green-600 text-black px-2 py-1 rounded hover:bg-green-700">Add</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<hr class="mb-6" />

<!-- Expenses Section -->
<h2 class="text-2xl font-semibold mb-4">Expenses</h2>

<form method="POST" action="{{ route('expenses.store', $event) }}" class="mb-6 max-w-lg bg-white p-4 rounded shadow">
    @csrf
    <div class="mb-4">
        <label class="block mb-1 font-medium">Category</label>
        <select name="category" required class="w-full border rounded p-2">
            <option value="">Select Category</option>
            <option value="Food">Food</option>
            <option value="Hotel">Hotel</option>
            <option value="Travel">Travel</option>
            <option value="Other">Other</option>
        </select>
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-medium">Description</label>
        <textarea name="description" rows="2" class="w-full border rounded p-2"></textarea>
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-medium">Amount ($)</label>
        <input type="number" step="0.01" name="amount" required class="w-full border rounded p-2" />
    </div>
    <div class="mb-4">
        <label class="block mb-1 font-medium">Expense Date</label>
        <input type="date" name="expense_date" required class="w-full border rounded p-2" />
    </div>
    <button type="submit" class="bg-red-600 text-black px-4 py-2 rounded hover:bg-red-700">Add Expense</button>
</form>

@if($event->expenses->isEmpty())
    <p>No expenses recorded yet.</p>
@else
    <table class="min-w-full bg-white rounded shadow">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 text-left">Category</th>
                <th class="py-2 px-4 text-left">Description</th>
                <th class="py-2 px-4 text-left">Amount</th>
                <th class="py-2 px-4 text-left">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($event->expenses as $expense)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ $expense->category }}</td>
                    <td class="py-2 px-4">{{ $expense->description ?? '-' }}</td>
                    <td class="py-2 px-4">${{ number_format($expense->amount, 2) }}</td>
                    <td class="py-2 px-4">{{ $expense->expense_date->format('M d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection
