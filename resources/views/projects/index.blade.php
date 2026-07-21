<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Projects
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('projects.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                    + New Project
                </a>

                 @if ($projects->isEmpty())
                    <p>You don't have any projects yet.</p>
                @else
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">Name</th>
                                <th class="py-2">Status</th>
                                <th class="py-2">Progress</th>
                                <th class="py-2">Created</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr class="border-b">
                                    <td class="py-2">
                                        <a href="{{ route('projects.show', $project) }}" class="text-blue-600 underline">
                                            {{ $project->name }}
                                        </a>
                                    </td>
                                    <td class="py-2 capitalize">{{ $project->status }}</td>
                                    <td class="py-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $project->completionPercentage() }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $project->completionPercentage() }}%</span>
                                    </td>
                                    <td class="py-2">{{ $project->created_at->format('M d, Y') }}</td>
                                    <td class="py-2 space-x-2">
                                        <a href="{{ route('projects.edit', $project) }}" class="text-yellow-600">Edit</a>

                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Delete this project?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600">Delete</button>
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