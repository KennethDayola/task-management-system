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

                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-lg">Tasks</h3>
                    <a href="{{ route('projects.tasks.create', $project) }}" class="text-blue-600">+ Add Task</a>
                </div>

                {{-- Status filter --}}
                <div class="mb-4 flex gap-3 text-sm">
                    <a href="{{ route('projects.show', $project) }}"
                       class="{{ request('status') ? 'text-gray-500' : 'font-semibold text-blue-600' }}">
                        All
                    </a>
                    <a href="{{ route('projects.show', ['project' => $project, 'status' => 'pending']) }}"
                       class="{{ request('status') === 'pending' ? 'font-semibold text-blue-600' : 'text-gray-500' }}">
                        Pending
                    </a>
                    <a href="{{ route('projects.show', ['project' => $project, 'status' => 'in_progress']) }}"
                       class="{{ request('status') === 'in_progress' ? 'font-semibold text-blue-600' : 'text-gray-500' }}">
                        In Progress
                    </a>
                    <a href="{{ route('projects.show', ['project' => $project, 'status' => 'completed']) }}"
                       class="{{ request('status') === 'completed' ? 'font-semibold text-blue-600' : 'text-gray-500' }}">
                        Completed
                    </a>
                </div>

                @forelse ($tasks as $task)
                    <div class="border-b py-3 flex justify-between items-start">
                        <div>
                            <p class="font-medium">{{ $task->title }}</p>
                            @if ($task->description)
                                <p class="text-sm text-gray-600">{{ $task->description }}</p>
                            @endif
                            <p class="text-sm text-gray-500">
                                Due: {{ $task->due_date->format('M d, Y') }}
                                <span class="mx-1">&middot;</span>
                                <span class="capitalize">{{ str_replace('_', ' ', $task->status) }}</span>
                            </p>
                        </div>
                        <div class="flex gap-3 text-sm">
                            <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-600">Edit</a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                  onsubmit="return confirm('Delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No tasks yet.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>