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
                <th class="py-2 px-4 text-left">View Payments</th>
            </tr>
        </thead>
        <tbody>
            @foreach($event->participants as $participant)
                <tr class="border-t" x-data="{ showModal: false }">
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
                    <td class="py-2 px-4">
                        <!-- Button to open modal -->
                        <button @click="showModal = true" class="bg-indigo-600 text-black px-3 py-1 rounded hover:bg-indigo-700">
                            View Payments
                        </button>

                        <!-- Modal -->
                        <div 
                            x-show="showModal" 
                            style="display: none;" 
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                            @keydown.escape.window="showModal = false"
                        >
                            <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[80vh] overflow-auto p-6 relative">
                                <!-- Close button -->
                                <button 
                                    @click="showModal = false" 
                                    class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl font-bold"
                                    aria-label="Close modal"
                                >
                                    &times;
                                </button>

                                <h2 class="text-2xl font-semibold mb-4">Payments History for {{ $participant->name }}</h2>

                                @if($participant->payments->isEmpty())
                                    <p>No payments made yet.</p>
                                @else
                                    <table class="min-w-full bg-white rounded shadow">
                                        <thead class="bg-gray-200 sticky top-0">
                                            <tr>
                                                <th class="py-2 px-4 text-left">Payment Amount</th>
                                                <th class="py-2 px-4 text-left">Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($participant->payments as $payment)
                                                <tr class="border-t">
                                                    <td class="py-2 px-4">${{ number_format($payment->amount, 2) }}</td>
                                                    <td class="py-2 px-4">{{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
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
