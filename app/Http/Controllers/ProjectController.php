<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('creator')->latest()->get();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // For assigning created_by if needed
        $categories = [
            Project::CATEGORY_PROJECT => 'Project',
            Project::CATEGORY_MEETING => 'Meeting',
        ];

        return view('projects.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'starting_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:starting_date',
            'category' => 'required|in:' . implode(',', [Project::CATEGORY_PROJECT, Project::CATEGORY_MEETING]),
        ]);

        $createdBy = $request->created_by ?? User::first()->id;
        Project::create([
            'title' => $request->title,
            'starting_date' => $request->starting_date,
            'end_date' => $request->end_date,
            'category' => $request->category,
            // 'created_by' => Auth::id(), // or $request->created_by if you want to assign manually
            'created_by' => $createdBy,

        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = Project::with('creator')->findOrFail($id);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $users = User::all();
        $categories = [
            Project::CATEGORY_PROJECT => 'Project',
            Project::CATEGORY_MEETING => 'Meeting',
        ];

        return view('projects.edit', compact('project', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'starting_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:starting_date',
            'category' => 'required|in:' . implode(',', [Project::CATEGORY_PROJECT, Project::CATEGORY_MEETING]),
        ]);

        $project = Project::findOrFail($id);
        $project->update([
            'title' => $request->title,
            'starting_date' => $request->starting_date,
            'end_date' => $request->end_date,
            'category' => $request->category,
            'created_by' => $request->created_by ?? $project->created_by,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
