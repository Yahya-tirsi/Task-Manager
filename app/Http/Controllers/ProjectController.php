<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Validator;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        return response()->json($project);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $project = Project::create($validatedData);

            return response()->json([
                'project' => $project
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return JSON response for validation errors
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function update(Request $request, Project $project)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $project->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully',
                'data' => $project,
            ], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'success' => false,
                'message' => 'Failed to update project',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
    
        return response()->json(['message' => 'Projet supprimé avec succès']);
    }

    public function getProjects()
    {
        $projects = Project::all();

        return response()->json([
            'project' => $projects
        ], 201);
    }

    public function index()
    {
        $projects = Project::all();
        return response()->json([
            'project' => $projects
        ], 201);
    }
}
