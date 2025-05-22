@extends('layouts.app')

@section('title', $event->name)
@push('styles')
<style>
    .marquee {
        white-space: nowrap;
        overflow: hidden;
        box-sizing: border-box;
        animation: marquee 10s linear infinite;
    }

    @keyframes marquee {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
</style>
@endpush
@section('content')
<div class="container my-5">
   <h1 class="mb-4 display-5 fw-bold text-primary">{{ $event->name }}</h1>

    <div class="mb-4">
        <ul class="list-group fs-5">
            <li class="list-group-item"><strong>Destination:</strong> {{ $event->destination }}</li>
            <li class="list-group-item">
                <strong>Date:</strong>
                <div class="text-success fw-bold marquee">
                    {{ $event->date->format('M d, Y') }}
                </div>
            </li>
            <li class="list-group-item"><strong>Budget:</strong> ${{ number_format($event->budget, 2) }}</li>
            <li class="list-group-item"><strong>Total Contributions:</strong> ${{ number_format($event->total_contributions, 2) }}</li>
            <li class="list-group-item"><strong>Total Expenses:</strong> ${{ number_format($event->total_expenses, 2) }}</li>
            <li class="list-group-item text-danger fw-semibold"><strong>Total Remaining Contribution:</strong> ${{ number_format($event->total_contributions - $event->total_expenses, 2) }}</li>
        </ul>
    </div>

    <hr>

    <!-- Participants -->
    <h2 class="mb-3 fw-bold text-secondary fs-4">Participants</h2>

    <form method="POST" action="{{ route('participants.store', $event) }}" class="row g-3 mb-4">
        @csrf
        <div class="col-md-5">
            <label class="form-label">Name</label>
            <input type="text" name="name" required class="form-control">
        </div>
        <div class="col-md-5">
            <label class="form-label">Expected Contribution ($)</label>
            <input type="number" step="0.01" name="expected_contribution" required class="form-control">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Add Participant</button>
        </div>
    </form>

    @if($event->participants->isEmpty())
        <p class="text-muted">No participants yet.</p>
    @else
        <div class="table-responsive mb-5">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Expected Contribution</th>
                        <th>Total Paid</th>
                        <th>Add Payment</th>
                        <th>View Payments</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($event->participants as $participant)
                    <tr>
                        <td>{{ $participant->name }}</td>
                        <td>${{ number_format($participant->expected_contribution, 2) }}</td>
                        <td>${{ number_format($participant->total_paid, 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('payments.store', $participant) }}" class="d-flex flex-wrap gap-2">
                                @csrf
                                <input type="number" step="0.01" name="amount" placeholder="Amount" required class="form-control form-control-sm w-auto">
                                <input type="date" name="paid_at" required class="form-control form-control-sm w-auto">
                                <button type="submit" class="btn btn-success btn-sm">Add</button>
                            </form>
                        </td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $participant->id }}">
                                View
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="paymentModal{{ $participant->id }}" tabindex="-1" aria-labelledby="paymentModalLabel{{ $participant->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="paymentModalLabel{{ $participant->id }}">Payments from {{ $participant->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if($participant->payments->isEmpty())
                                                <p class="text-muted">No payments recorded.</p>
                                            @else
                                                <table class="table table-sm table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Amount</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $totalPayment = 0; @endphp
                                                        @foreach($participant->payments as $payment)
                                                        @php $totalPayment += $payment->amount; @endphp
                                                        <tr>
                                                            <td>${{ number_format($payment->amount, 2) }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y') }}</td>
                                                        </tr>
                                                        @endforeach
                                                        <tr class="table-secondary fw-bold">
                                                            <td>Total</td>
                                                            <td>${{ number_format($totalPayment, 2) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <hr>

    <!-- Expenses -->
    <h2 class="mb-3 fw-bold text-danger fs-4">Expenses</h2>

    <form method="POST" action="{{ route('expenses.store', $event) }}" class="row g-3 mb-4">
        @csrf
        <div class="col-md-4">
            <label class="form-label">Category</label>
            <select name="category" class="form-select" required>
                <option value="">Select</option>
                <option value="Food">Food</option>
                <option value="Hotel">Hotel</option>
                <option value="Travel">Travel</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Amount ($)</label>
            <input type="number" step="0.01" name="amount" required class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Date</label>
            <input type="date" name="expense_date" required class="form-control">
        </div>
        <div class="col-md-12">
            <label class="form-label">Description</label>
            <textarea name="description" rows="2" class="form-control"></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-danger">Add Expense</button>
        </div>
    </form>

    @if($event->expenses->isEmpty())
        <p class="text-muted">No expenses recorded.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($event->expenses as $expense)
                    <tr>
                        <td>{{ $expense->category }}</td>
                        <td>{{ $expense->description ?? '-' }}</td>
                        <td>${{ number_format($expense->amount, 2) }}</td>
                        <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
