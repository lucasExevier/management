<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = auth()->user()->projects()->with('tasks.project')->get()->pluck('tasks')->flatten();
        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:todo,in_progress,done,blocked',
            'priority' => 'required|string|in:low,medium,high,urgent',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'board_id' => 'nullable|exists:boards,id',
            'due_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Ensure the project belongs to the authenticated user
        $project = auth()->user()->projects()->findOrFail($request->project_id);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
            'board_id' => $request->board_id ?: null,
            'due_date' => $request->due_date,
        ]);

        return response()->json($task->load('assignedUser', 'creator', 'project', 'board'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::whereHas('project', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('assignedUser', 'creator', 'project', 'board')->findOrFail($id);

        return response()->json($task);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::whereHas('project', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|string|in:todo,in_progress,done,blocked',
            'priority' => 'sometimes|required|string|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'board_id' => 'nullable|exists:boards,id',
            'due_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task->update($request->only(['title', 'description', 'status', 'priority', 'assigned_to', 'board_id', 'due_date']));

        return response()->json($task->load('assignedUser', 'creator', 'project', 'board'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::whereHas('project', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
