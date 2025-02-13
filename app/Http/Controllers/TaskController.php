<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
        ]);

        Task::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'project_id' => $validatedData['project_id'],
        ]);

        return back()->with('message', '🎉 Task created successfully!');
    }

    public function store2(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = new Task($validatedData);
        $project->tasks()->save($task);

        return back()->with("succes", "🎉 Task created successfully!");
    }

    public function index(Project $project)
    {
        $tasks = Task::all();

        return view('tasks.index', compact('project', 'tasks'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:A faire,Encours,Terminer',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully!']);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:A faire,Encours,Terminer',
        ]);

        $task->update(['status' => $request->status]);

        return response()->json(['message' => 'Task status updated successfully']);
    }

    public function tsksProject()
    {
        $tasks = Task::all();
        return response()->json(
            $tasks
        );
    }

}
