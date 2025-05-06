<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:pending,in progress,complete',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $userId = auth()->user()->can('assign-task') ?
            $request->assigned_to :
            auth()->id();

        $task = Task::create([
            'task' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => $userId
        ]);

        return redirect()->route('dashboard')->with('success', 'Task created successfully');
    }
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $users = User::all();
        return view('add', compact('task', 'users'));
    }
    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);
            
            $userId = auth()->user()->can('assign-task') ?
                $request->assigned_to :
                $task->user_id;

            $task->update([
                'task' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'user_id' => $userId
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Task updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update task');
        }
    }
    public function delete($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return redirect()->route('dashboard')->with('success', 'Task deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete task');
        }
    }
    public function index()
    {
        if (auth()->user()->can('all-task')) {
            $tasks = Task::with('user')->get();
        } else {
            $tasks = Task::where('user_id', auth()->id())->get();
        }

        return view('dashboard', compact('tasks'));
    }
}
