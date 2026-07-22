<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Projects
            </h2>
            <a href="{{ route('projects.create') }}" class="btn-primary text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Project
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="alert-success">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($stats['total'] > 0)
                {{-- Quick stats --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="card p-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Projects</p>
                        <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                    </div>
                    <div class="card p-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Active</p>
                        <p class="text-2xl font-semibold text-indigo-600 mt-1">{{ $stats['active'] }}</p>
                    </div>
                    <div class="card p-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Completed</p>
                        <p class="text-2xl font-semibold text-green-600 mt-1">{{ $stats['completed'] }}</p>
                    </div>
                </div>
            @endif

            <div class="card p-6">

                @if ($projects->isEmpty())
                    <div class="text-center py-16">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h5l2 2h7a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <p class="text-gray-500 mb-3">You don't have any projects yet.</p>
                        <a href="{{ route('projects.create') }}" class="text-indigo-600 text-sm font-medium hover:underline">
                            + Create your first project
                        </a>
                    </div>
                @else
                    <table class="projects-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>
                                        <a href="{{ route('projects.show', $project) }}" class="project-link">
                                            {{ $project->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($project->tasks_count === 0)
                                            <span class="status-badge" style="background-color:#f3f4f6; color:#9ca3af;">
                                                No tasks yet
                                            </span>
                                        @else
                                            <span class="status-badge status-{{ $project->status }}">
                                                {{ $project->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($project->tasks_count === 0)
                                            <span class="text-xs text-gray-400 italic">No tasks yet</span>
                                        @else
                                            <div class="flex items-center gap-2">
                                                <div class="progress-bar-track">
                                                    <div class="progress-bar-fill" style="width: {{ $project->completionPercentage() }}%"></div>
                                                </div>
                                                <span class="text-xs text-gray-500">{{ $project->completionPercentage() }}%</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-gray-500">{{ $project->created_at->format('M d, Y') }}</td>
                                    <td class="space-x-2">
                                        <a href="{{ route('projects.edit', $project) }}" class="action-edit">Edit</a>
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Delete this project?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $projects->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>