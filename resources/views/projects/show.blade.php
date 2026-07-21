<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-6">
                    <p class="text-gray-600">{{ $project->description ?: 'No description provided.' }}</p>
                    <p class="mt-2">
                        <span class="font-medium">Status:</span>
                        <span class="capitalize">{{ $project->status }}</span>
                    </p>
                    <p class="text-sm text-gray-500">
                        Created: {{ $project->created_at->format('M d, Y') }}
                    </p>
                </div>

                <div class="flex gap-4 mb-6">
                    <a href="{{ route('projects.edit', $project) }}" class="text-yellow-600">Edit Project</a>
                    <a href="{{ route('projects.index') }}" class="text-gray-600">Back to Projects</a>
                </div>

                <hr class="my-6">

                <h3 class="font-semibold text-lg mb-4">Tasks</h3>
                <p class="text-gray-500">Task list coming soon.</p>

            </div>
        </div>
    </div>
</x-app-layout>