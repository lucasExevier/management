<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = auth()->user()->reports()->with('user')->orderBy('report_date', 'desc')->get();
        return response()->json($reports);
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
            'report_date' => 'required|date',
            'tasks' => 'nullable|array',
            'tasks.*' => 'string|max:255',
            'work_in_progress' => 'nullable|array',
            'work_in_progress.*' => 'string|max:255',
            'issues' => 'nullable|array',
            'issues.*' => 'string|max:255',
            'plans' => 'nullable|array',
            'plans.*' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if report already exists for this date
        $existingReport = Report::where('user_id', auth()->id())
            ->where('report_date', $request->report_date)
            ->first();

        if ($existingReport) {
            return response()->json(['errors' => ['report_date' => ['A report already exists for this date.']]], 422);
        }

        $report = Report::create([
            'report_date' => $request->report_date,
            'user_id' => auth()->id(),
            'tasks' => $request->tasks,
            'work_in_progress' => $request->work_in_progress,
            'issues' => $request->issues,
            'plans' => $request->plans,
        ]);

        return response()->json($report->load('user'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = Report::where('user_id', auth()->id())->with('user')->findOrFail($id);
        return response()->json($report);
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
        $report = Report::where('user_id', auth()->id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'report_date' => 'sometimes|required|date',
            'tasks' => 'nullable|array',
            'tasks.*' => 'string|max:255',
            'work_in_progress' => 'nullable|array',
            'work_in_progress.*' => 'string|max:255',
            'issues' => 'nullable|array',
            'issues.*' => 'string|max:255',
            'plans' => 'nullable|array',
            'plans.*' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if another report exists for this date (excluding current)
        if ($request->has('report_date')) {
            $existingReport = Report::where('user_id', auth()->id())
                ->where('report_date', $request->report_date)
                ->where('id', '!=', $id)
                ->first();

            if ($existingReport) {
                return response()->json(['errors' => ['report_date' => ['A report already exists for this date.']]], 422);
            }
        }

        $report->update($request->only(['report_date', 'tasks', 'work_in_progress', 'issues', 'plans']));

        return response()->json($report->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $report = Report::where('user_id', auth()->id())->findOrFail($id);
        $report->delete();

        return response()->json(['message' => 'Report deleted successfully']);
    }
}
