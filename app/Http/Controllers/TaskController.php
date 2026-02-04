<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\TaskRemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with(['project', 'assignee', 'creator'])
            ->mainTasks()
            ->latest()
            ->paginate(20);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Display tasks assigned to current user.
     */
    public function assignedToMe()
    {
        $tasks = Task::with(['project', 'creator'])
            ->assignedToMe()
            ->latest()
            ->paginate(20);

        return view('tasks.assigned', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        $parentTasks = Task::mainTasks()->get();

        return view('tasks.create', compact('projects', 'users', 'parentTasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'parent_id' => 'nullable|exists:tasks,id',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        // Get current user ID or use first user if not authenticated
        $createdBy = auth()->id() ?? User::first()->id;

        $task = Task::create([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
            'created_by' => $createdBy,
        ]);

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::with([
            'project',
            'creator',
            'assignee',
            'parent',
            'subtasks.assignee',
            'subtasks.creator',
            'remarks.user'
        ])->findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $projects = Project::all();
        $users = User::all();
        $parentTasks = Task::mainTasks()->where('id', '!=', $id)->get();

        return view('tasks.edit', compact('task', 'projects', 'users', 'parentTasks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'parent_id' => 'nullable|exists:tasks,id',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    /**
     * Add remark to task
     */
    public function addRemark(Request $request, $id)
    {
        $request->validate([
            'remark' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        $task = Task::findOrFail($id);
        $userId = auth()->id() ?? User::first()->id;

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('task-attachments', 'public');
        }

        $remark = TaskRemark::create([
            'task_id' => $task->id,
            'user_id' => $userId,
            'remark' => $request->remark,
            'attachment_path' => $attachmentPath,
        ]);

        return back()->with('success', 'Remark added successfully.');
    }

    /**
     * Delete remark
     */
    public function deleteRemark($taskId, $remarkId)
    {
        $remark = TaskRemark::where('task_id', $taskId)->findOrFail($remarkId);

        // Delete attachment if exists
        if ($remark->attachment_path) {
            Storage::disk('public')->delete($remark->attachment_path);
        }

        $remark->delete();

        return back()->with('success', 'Remark deleted successfully.');
    }

    /**
     * Update task status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task = Task::findOrFail($id);
        $task->update(['status' => $request->status]);

        return back()->with('success', 'Task status updated.');
    }
}
