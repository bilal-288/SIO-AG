<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTimeLogRequest;
use App\Models\TimeLog;
use Carbon\Carbon;
use App\Models\Project; 

/**
 * Class TimeLogController
 * @package App\Http\Controllers
 */
class TimeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $timeLogs = TimeLog::with('project') // Eager load the 'project' relationship
            ->where('user_id', $userId)
            ->get();
    // print_r($timeLogs);exit;
        return view('time_logs.index', compact('timeLogs'));
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $projects = Project::all(); // Fetch all projects from the database

        return view('time_logs.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateTimeLogRequest  $request)
    {
        $data = $request->validated();

        $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('start_time')); // Corrected format
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('end_time')); // Corrected format

        // Get the ID of the currently authenticated user
        $userId = auth()->user()->id;

        TimeLog::create([
            'start_time' => $startDateTime,
            'end_time' => $endDateTime,
            'user_id' => $userId,
            'project_id' => $request->input('project_id'), // Assign the selected project ID
        ]);

        return redirect()->route('time-logs.index')->with('success', 'Time log recorded successfully.');
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeLog  $timeLog
     * @return \Illuminate\View\View
     */
    public function edit(TimeLog $timeLog)
    {
        $projects = Project::all();

        return view('time_logs.edit', compact('timeLog', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeLog  $timeLog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateTimeLogRequest $request, TimeLog $timeLog)
    {
        $data = $request->validated();
        
        $timeLog->update([
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'project_id' => $request->input('project_id'), // Update the project ID
        ]);

        return redirect()->route('time-logs.index')->with('success', 'Time log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeLog  $timeLog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TimeLog $timeLog)
    {
        $timeLog->delete();
        return redirect()->route('time-logs.index')->with('success', 'Time log deleted successfully.');
    }

    /**
     * Display evaluation data for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function evaluation()
    {
        // Get the ID of the currently authenticated user
        $userId = auth()->user()->id;

        // Retrieve TimeLog records for the user along with the associated projects
        $timeLogs = TimeLog::with('project')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $formattedEvaluationData = [];

        foreach ($timeLogs as $timeLog) {
            $startDateString = $timeLog['start_time'];
            $endDateString = $timeLog['end_time'];

            // Convert start and end date strings to Carbon objects
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $startDateString);
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $endDateString);

            // Calculate the time difference
            $interval = $endDate->diff($startDate);

            // Calculate the total hours, including days
            $totalHours = $interval->days * 24 + $interval->h;
            $totalMinutes = $interval->i;

            $formattedEvaluationData[] = [
                'start_date' => $startDateString,
                'end_date' => $endDateString,
                'total_hours' => $totalHours,
                'total_minutes' => $totalMinutes,
                'project_name' => $timeLog->project->name, // Include project name
            ];
        }

        return view('time_logs.evaluation', compact('formattedEvaluationData'));
    }

}
