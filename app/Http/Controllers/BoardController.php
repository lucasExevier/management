<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = auth()->user()->projects()->with('boards.project')->get()->pluck('boards')->flatten();
        return response()->json($boards);
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'position' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Ensure the project belongs to the authenticated user
        $project = auth()->user()->projects()->findOrFail($request->project_id);

        $position = $request->position ?? $project->boards()->max('position') + 1;

        $board = Board::create([
            'name' => $request->name,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'position' => $position,
        ]);

        return response()->json($board->load('project'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $board = Board::whereHas('project', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('project', 'tasks')->findOrFail($id);

        return response()->json($board);
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
        $board = Board::whereHas('project', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $board->update($request->only(['name', 'description', 'position']));

        return response()->json($board->load('project'));
    }

    /**
     * Update the position of the specified resource.
     */
    public function updatePosition(Request $request, string $id)
    {
        $board = Board::whereHas('project', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'position' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $board->update(['position' => $request->position]);

        return response()->json($board->load('project'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $board = Board::whereHas('project', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $board->delete();

        return response()->json(['message' => 'Board deleted successfully']);
    }
}
