<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('projects.edit', $project) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('projects.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="alert-success">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Overview card --}}
            @php
                $totalTasks = $project->tasks()->count();
                $completedTasks = $project->tasks()->where('status', 'completed')->count();
                $percentage = $project->completionPercentage();
            @endphp

            <div class="card p-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <p class="text-gray-600">{{ $project->description ?: 'No description provided.' }}</p>
                    @if ($totalTasks === 0)
                        <span class="status-badge flex-shrink-0" style="background-color:#f3f4f6; color:#9ca3af;">
                            No tasks yet
                        </span>
                    @else
                        <span class="status-badge status-{{ $project->status }} flex-shrink-0">{{ $project->status }}</span>
                    @endif
                </div>

                <div class="mb-1.5 flex justify-between text-sm">
                    <span class="font-medium text-gray-700">{{ $completedTasks }} of {{ $totalTasks }} tasks completed</span>
                    <span class="text-gray-500">{{ $percentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 h-2 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                </div>

                <p class="text-xs text-gray-400 mt-3">Created {{ $project->created_at->format('M d, Y') }}</p>
            </div>

            {{-- Tasks card --}}
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-lg text-gray-800">Tasks</h3>
                    <a href="{{ route('projects.tasks.create', $project) }}" class="btn-primary text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Task
                    </a>
                </div>

                {{-- Combined search + filter row --}}
                <form method="GET" action="{{ route('projects.show', $project) }}" class="mb-5">
                    <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                        <div class="relative flex-1 max-w-xs">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search tasks..."
                                class="w-full border border-gray-300 rounded-md pl-9 pr-3 py-1.5 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1">
                            @if (request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                        </div>

                        <div class="flex gap-1.5 text-sm flex-wrap">
                            <a href="{{ route('projects.show', $project) }}"
                               class="px-3 py-1 rounded-full {{ request('status') ? 'text-gray-500 hover:bg-gray-100' : 'font-semibold bg-indigo-100 text-indigo-700' }}">
                                All
                            </a>
                            <a href="{{ route('projects.show', ['project' => $project, 'status' => 'pending']) }}"
                               class="px-3 py-1 rounded-full {{ request('status') === 'pending' ? 'font-semibold bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:bg-gray-100' }}">
                                Pending
                            </a>
                            <a href="{{ route('projects.show', ['project' => $project, 'status' => 'in_progress']) }}"
                               class="px-3 py-1 rounded-full {{ request('status') === 'in_progress' ? 'font-semibold bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:bg-gray-100' }}">
                                In Progress
                            </a>
                            <a href="{{ route('projects.show', ['project' => $project, 'status' => 'completed']) }}"
                               class="px-3 py-1 rounded-full {{ request('status') === 'completed' ? 'font-semibold bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:bg-gray-100' }}">
                                Completed
                            </a>
                        </div>
                    </div>

                    @if (request('search'))
                        <div class="mt-2 text-sm">
                            <span class="text-gray-500">Showing results for "{{ request('search') }}"</span>
                            <a href="{{ route('projects.show', array_filter(['project' => $project, 'status' => request('status')])) }}"
                               class="text-indigo-600 hover:underline ml-2">Clear</a>
                        </div>
                    @endif
                </form>

                {{-- Task list --}}
                @forelse ($tasks as $task)
                    @php
                        $accentColor = match($task->status) {
                            'completed' => 'bg-green-500',
                            'in_progress' => 'bg-indigo-500',
                            default => 'bg-gray-300',
                        };
                    @endphp
                    <div class="flex items-stretch gap-3 py-3 border-b border-gray-100 last:border-0">
                        <div class="w-1 rounded-full {{ $accentColor }} flex-shrink-0"></div>

                        <div class="flex-1 min-w-0 flex justify-between items-start gap-4">
                            <div class="min-w-0">
                                <p class="font-medium text-gray-800 flex items-center gap-2">
                                    <span class="truncate">{{ $task->title }}</span>
                                    @if ($task->isOverdue())
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-red-600 bg-red-100 px-2 py-0.5 rounded-full flex-shrink-0">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                                            </svg>
                                            Overdue
                                        </span>
                                    @endif
                                </p>
                                @if ($task->description)
                                    <p class="text-sm text-gray-500 mt-0.5 truncate">{{ $task->description }}</p>
                                @endif
                                <p class="text-xs mt-1.5 {{ $task->isOverdue() ? 'text-red-600 font-medium' : 'text-gray-400' }}">
                                    Due {{ $task->due_date->format('M d, Y') }}
                                    <span class="mx-1">&middot;</span>
                                    <span class="capitalize">{{ str_replace('_', ' ', $task->status) }}</span>
                                </p>
                            </div>
                            <div class="flex gap-3 text-sm flex-shrink-0">
                                <a href="{{ route('tasks.edit', $task) }}" class="action-edit">Edit</a>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                    onsubmit="return confirm('Delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-delete">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 mb-3">
                            {{ request('search') || request('status') ? 'No tasks match your filters.' : 'No tasks yet.' }}
                        </p>
                        @unless (request('search') || request('status'))
                            <a href="{{ route('projects.tasks.create', $project) }}" class="text-indigo-600 text-sm font-medium hover:underline">
                                + Add your first task
                            </a>
                        @endunless
                    </div>
                @endforelse

                @if ($tasks->hasPages())
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        {{ $tasks->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>