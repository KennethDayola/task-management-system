<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Task to {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('projects.tasks.store', $project) }}">
                    @csrf

                    <div class="mb-4">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}">
                        @error('title')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description">Description</label>
                        <textarea name="description" id="description">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="due_date">Due Date</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}">
                        @error('due_date')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="pending" @selected(old('status') === 'pending')>Pending</option>
                            <option value="in_progress" @selected(old('status') === 'in_progress')>In Progress</option>
                            <option value="completed" @selected(old('status') === 'completed')>Completed</option>
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit">Create Task</button>
                    <a href="{{ route('projects.show', $project) }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>