@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
<div class="min-h-screen bg-gradient-to-tr from-green-100 to-white flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-10">
        <h1 class="text-4xl font-extrabold text-green-700 mb-8 text-center">
            🎉 Create Your Event
        </h1>

        <form method="POST" action="{{ route('events.store') }}" class="space-y-6" novalidate>
            @csrf

            <!-- Event Name -->
            <div>
                <label for="name" class="block mb-2 text-base font-semibold text-gray-700">Event Name</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    placeholder="Enter event name"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-700 placeholder-gray-400
                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                />
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Budget -->
            <div>
                <label for="budget" class="block mb-2 text-base font-semibold text-gray-700">Budget ($)</label>
                <input
                    id="budget"
                    name="budget"
                    type="number"
                    step="0.01"
                    value="{{ old('budget') }}"
                    required
                    placeholder="Set your budget"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-700 placeholder-gray-400
                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                />
                @error('budget')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Destination -->
            <div>
                <label for="destination" class="block mb-2 text-base font-semibold text-gray-700">Destination</label>
                <input
                    id="destination"
                    name="destination"
                    type="text"
                    value="{{ old('destination') }}"
                    required
                    placeholder="Where is your event?"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-700 placeholder-gray-400
                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                />
                @error('destination')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Event Date -->
            <div>
                <label for="date" class="block mb-2 text-base font-semibold text-gray-700">Event Date</label>
                <input
                    id="date"
                    name="date"
                    type="date"
                    value="{{ old('date') }}"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-700
                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                />
                @error('date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="btn-primary w-full flex justify-center items-center gap-2 py-4 text-lg font-semibold rounded-lg shadow-md transition duration-300 focus:outline-none focus:ring-4"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                Create Event
            </button>
        </form>
    </div>
</div>
@endsection
