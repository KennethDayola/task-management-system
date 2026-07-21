<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        return Auth::user()->projects()->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,completed',
        ]);

        $project = Auth::user()->projects()->create($validated);

        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return $project->load('tasks');
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:active,completed',
        ]);

        $project->update($validated);

        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return response()->json(null, 204);
    }
}