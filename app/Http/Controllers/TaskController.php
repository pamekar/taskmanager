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
    public function index()
    {
        $tasks = Auth::user()->tasks;
        if (Request::capture()->isXmlHttpRequest()) {
            return response()->json($tasks);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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

        if ($request->isJson()) {
            return response()->json($task);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $task = Auth::user()->tasks()->where('task_id', $id)->first();
        if (Request::capture()->isXmlHttpRequest()) {
            return $task;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
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

        if (Request::capture()->isXmlHttpRequest()) {
            return response()->json($task);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
