@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
    <h1>Edit Event</h1>

    <form action="{{ route('events.update', $event) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Event Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="destination" class="form-label">Destination</label>
            <input type="text" name="destination" class="form-control" value="{{ old('destination', $event->destination) }}" required>
        </div>

        <div class="mb-3">
            <label for="budget" class="form-label">Budget (€)</label>
            <input type="number" name="budget" step="0.01" class="form-control" value="{{ old('budget', $event->budget) }}" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Event Date</label>
            <input type="date" name="date" class="form-control" value="{{ old('date', $event->date->format('Y-m-d')) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
@endsection
