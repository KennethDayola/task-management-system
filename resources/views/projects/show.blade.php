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
                @php
                    $totalTasks = $project->tasks()->count();
                    $completedTasks = $project->tasks()->where('status', 'completed')->count();
                    $percentage = $project->completionPercentage();
                @endphp

                <div class="mb-6">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium">Progress</span>
                        <span>{{ $completedTasks }} / {{ $totalTasks }} tasks completed ({{ $percentage }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
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

                {{-- Search --}}
                <form method="GET" action="{{ route('projects.show', $project) }}" class="mb-4 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search tasks by title..."
                        class="border rounded px-3 py-1 text-sm flex-1">

                    {{-- preserve the active status filter when searching --}}
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <button type="submit" class="text-sm text-blue-600">Search</button>

                    @if (request('search'))
                        <a href="{{ route('projects.show', array_filter(['project' => $project, 'status' => request('status')])) }}"
                        class="text-sm text-gray-500">Clear</a>
                    @endif
                </form>

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
                    <div class="border-b py-3 flex justify-between items-start {{ $task->isOverdue() ? 'bg-red-50' : '' }}">
                        <div>
                            <p class="font-medium">
                                {{ $task->title }}
                                @if ($task->isOverdue())
                                    <span class="ml-2 text-xs font-semibold text-red-600 bg-red-100 px-2 py-0.5 rounded">Overdue</span>
                                @endif
                            </p>
                            @if ($task->description)
                                <p class="text-sm text-gray-600">{{ $task->description }}</p>
                            @endif
                            <p class="text-sm {{ $task->isOverdue() ? 'text-red-600 font-medium' : 'text-gray-500' }}">
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
                <div class="mt-4">
                    {{ $tasks->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>