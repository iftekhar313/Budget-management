@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
<h1 class="text-2xl font-bold mb-6">Create Event</h1>

<form method="POST" action="{{ route('events.store') }}" class="bg-white p-6 rounded shadow max-w-lg">
    @csrf

    <label class="block mb-4">
        <span class="text-gray-700">Event Name</span>
        <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full border-gray-300 rounded" />
        @error('name') <p class="text-red-600">{{ $message }}</p> @enderror
    </label>

    <label class="block mb-4">
        <span class="text-gray-700">Budget ($)</span>
        <input type="number" step="0.01" name="budget" value="{{ old('budget') }}" required class="mt-1 block w-full border-gray-300 rounded" />
        @error('budget') <p class="text-red-600">{{ $message }}</p> @enderror
    </label>

    <label class="block mb-4">
        <span class="text-gray-700">Destination</span>
        <input type="text" name="destination" value="{{ old('destination') }}" required class="mt-1 block w-full border-gray-300 rounded" />
        @error('destination') <p class="text-red-600">{{ $message }}</p> @enderror
    </label>

    <label class="block mb-6">
        <span class="text-gray-700">Event Date</span>
        <input type="date" name="date" value="{{ old('date') }}" required class="mt-1 block w-full border-gray-300 rounded" />
        @error('date') <p class="text-red-600">{{ $message }}</p> @enderror
    </label>

    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Create Event</button>
</form>
@endsection
