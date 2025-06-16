@extends('template')

@section('title', 'Spaces')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded shadow-md p-6 space-y-8">

        <!-- Heading -->
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Spaces</h1>
            <p class="text-sm text-gray-500">Create and view spaces below.</p>
        </div>

        <!-- Form -->
        <form method="POST" class="flex flex-col sm:flex-row sm:items-center gap-4">
            @csrf
            <input
                type="text"
                name="name"
                placeholder="Enter space name"
                class="w-full sm:flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            />
            <button
                type="submit"
                class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
                Add Space
            </button>
        </form>


        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">#</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($spaces as $index => $space)
                    <tr>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 text-sm text-gray-800 font-medium">{{ $space->name }}</td>
                        <td class="px-6 py-3 text-sm text-gray-800 font-medium space-x-4">
                            <a href="{{ route('setup-layout', ['id' => $space->id]) }}" class="text-blue-600 hover:underline">Setup layout</a>
                            <a href="{{ route('space-preview', ['id' => $space->id]) }}" class="text-blue-600 hover:underline">Preview</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-3 text-sm text-gray-500">No spaces found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
