<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task->subtasks()->create($validated);

        $request->session()->flash('success', 'زیروظیفه با موفقیت ایجاد شد.');
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, Subtask $subtask)
    {
        $this->authorize('update', $subtask->task);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'is_completed' => 'sometimes|required|boolean',
        ]);

        $subtask->update($validated);

        $request->session()->flash('success', 'زیروظیفه با موفقیت به‌روزرسانی شد.');
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtask $subtask)
    {
        $this->authorize('update', $subtask->task);

        $task = $subtask->task;
        $subtask->delete();

        // Check if all subtasks are deleted
        if ($task->subtasks()->count() === 0) {
            $task->update(['status' => 'todo']);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'زیرتسک با موفقیت حذف شد.');
    }
}
