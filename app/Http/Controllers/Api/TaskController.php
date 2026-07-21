<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task = $project->tasks()->create($validated);

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:pending,in_progress,completed',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(null, 204);
    }
}