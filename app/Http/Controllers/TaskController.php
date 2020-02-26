<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $tasks = Auth::user()->tasks;
        if ($request->is('api/*')) {
            return response()->json($tasks);
        }
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTask $request
     * @return void
     */
    public function store(StoreTask $request)
    {
        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description', null);
        $task->is_compulsory = false;
        $task->user_id = Auth::id();
        $task->start_at = $request->input('start_at', null);
        $task->end_at = $request->input('end_at', null);
        $task->save();

        // Assign task to active user
        Auth::user()->tasks()->attach($task->id, ['status' => 'pending']);

        if ($request->is('api/*')) {
            return response()->json($task, 201);
        }

        return redirect(route('tasks.show', $task->id))->with(['status' => "'$task->title' was created successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $task = Auth::user()->tasks()->where('task_id', $id)->firstOrFail();
        if ($request->is('api/*')) {
            return $task;
        }
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $task = Auth::user()->tasks()->where('task_id', $id)->first();
        if (Request::capture()->is('api/*')) {
            return $task;
        }
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateTask $request, $id)
    {
        $task = Task::whereId($id)->personal()->firstOrFail();

        if (isset($request->title)) {
            $task->title = $request->input('title');
        }
        if (isset($request->description)) {
            $task->description = $request->input('description');
        }
        if (isset($request->start_at)) {
            $task->start_at = $request->input('start_at');
        }
        if (isset($request->end_at)) {
            $task->end_at = $request->input('end_at');
        }
        $task->save();

        if ($request->is('api/*')) {
            return response()->json($task);
        }
        return redirect(route('tasks.show', $task->id))->with(['status' => "'$task->title'' was updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $task = Task::whereId($id)->personal()->first();

        if ($task) {
            $task->users()->detach();
            $task->delete();
        } else {
            $task = Task::find($id);
            $user = $task->users()->where('users.id', Auth::id())->firstOrFail();
            abort_if($task->is_compuslory ?? false, 403, "You can't delete a compulsory task.");

            $task->users()->detach(Auth::id());
        }

        if ($request->is('api/*')) {
            return response()->json(true, 204);
        }

        return redirect(route('tasks.index'))->with(['status' => "'$task->title' was deleted successfully"]);
    }
}
