<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class TaskController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:pending,in progress,complete',
        ]);
    
        $task = Task::create([
            'task' => $request->name,
            'description' => $request->description,
            'status' => $request->status, 
            'user_id' => Auth::id()
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Task created successfully');
    }
    public function edit($id)
    {
    $task = Task::findOrFail($id);
    // dd($task);
    return view('add', compact('task'));        
    }
    public function update(Request $request, $id)
    {
        try{
            $task = Task::findOrFail($id);
            $task->update($request->only(['name', 'description', 'Status']));
            return redirect()->route('dashboard')->with('success', 'Task updated successfully');
        }
        catch(\Exception $e){
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
        if (auth()->user()->hasRole(['admin', 'manager'])) {
           
            $tasks = Task::with('user')->get();
        } else {
            $tasks = Task::where('user_id', auth()->id())->get();
        }
        
        return view('dashboard', compact('tasks'));
    }
}
