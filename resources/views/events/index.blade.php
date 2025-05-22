@extends('layouts.app')
@section('title', 'My Events')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My Events</h1>
        <a href="{{ route('events.create') }}" class="btn btn-success">+ Create Event</a>
    </div>

    @if($events->isEmpty())
        <div class="alert alert-info">No events created yet.</div>
    @else
        <div class="row">
            @foreach($events as $event)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <p class="card-text"><strong>Destination:</strong> {{ $event->destination }}</p>
                            <p class="card-text"><strong>Budget:</strong> €{{ number_format($event->budget, 2) }}</p>
                            <p class="card-text"><strong>Date:</strong> {{ $event->date->format('M d, Y') }}</p>
                            <a href="{{ route('events.show', $event) }}" class="btn btn-outline-primary mt-2">View Details</a>
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-outline-secondary btn-sm">Edit</a>

                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
