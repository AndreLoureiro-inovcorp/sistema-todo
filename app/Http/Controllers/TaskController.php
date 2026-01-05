<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = auth()->user()->tasks();

        if ($request->status === 'completed') {
            $query->completed();
        } elseif ($request->status === 'pending') {
            $query->pending();
        }

        if ($request->priority) {
            $query->byPriority($request->priority);
        }

        if ($request->date_filter) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('due_date', today());
                    break;
                case 'week':
                    $query->whereBetween('due_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek(),
                    ]);
                    break;
                case 'overdue':
                    $query->where('due_date', '<', today())
                        ->where('is_completed', false);
                    break;
            }
        }

        $tasks = $query->latest()->get();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'filters' => $request->only(['status', 'priority', 'date_filter']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tasks/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        auth()->user()->tasks()->create($request->validated());

        return redirect()->route('tasks.index')
            ->with('success', 'Task criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Acesso negado.');
        }

        return Inertia::render('Tasks/Show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Acesso negado.');
        }

        return Inertia::render('Tasks/Edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('tasks.index')
            ->with('success', 'Task atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Acesso negado.');
        }

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task apagada com sucesso!');
    }

    /**
     * Toggle task completion status.
     */
    public function toggleComplete(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Acesso negado.');
        }

        $task->update([
            'is_completed' => ! $task->is_completed,
        ]);

        return back()->with('success', 'Status atualizado!');
    }
}
