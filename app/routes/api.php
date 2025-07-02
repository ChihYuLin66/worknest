<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Project;
use App\Models\Task;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/dashboard/stats', function () {
    return response()->json([
        'totalProjects' => Project::count(),
        'activeTasks' => Task::where('status', '!=', 'completed')->count(),
        'teamMembers' => 12, // Static for now
        'completionRate' => round((Task::where('status', 'completed')->count() / Task::count()) * 100)
    ]);
});

Route::get('/projects', function () {
    return Project::with('tasks')->get();
});

Route::get('/projects/recent', function () {
    return Project::latest()->take(3)->get();
});
