<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('projects.show', $task->project) }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Task</h2>
                <p class="text-sm text-gray-400">{{ $task->project->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-5">
                        <label for="title" class="block font-medium text-sm text-gray-700 mb-1">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" autofocus
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1 @error('title') border-red-400 @enderror">
                        @error('title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block font-medium text-sm text-gray-700 mb-1">
                            Description
                            <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <textarea name="description" id="description" rows="3"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="due_date" class="block font-medium text-sm text-gray-700 mb-1">
                                Due Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1 @error('due_date') border-red-400 @enderror">
                            @error('due_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block font-medium text-sm text-gray-700 mb-1">Status</label>
                            <select name="status" id="status"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1">
                                <option value="pending" @selected(old('status', $task->status) === 'pending')>Pending</option>
                                <option value="in_progress" @selected(old('status', $task->status) === 'in_progress')>In Progress</option>
                                <option value="completed" @selected(old('status', $task->status) === 'completed')>Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                        <button type="submit" class="btn-primary">Update Task</button>
                        <a href="{{ route('projects.show', $task->project) }}" class="text-gray-500 hover:text-gray-700 text-sm">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>