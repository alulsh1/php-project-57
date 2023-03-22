<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use Carbon\Carbon;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = TaskStatus::all();
        $date = new Carbon();
        return view("status.index", compact("statuses"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("status.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskStatusRequest $request)
    {
        $data = $request->validated();
        TaskStatus::firstOrCreate($data);
        flash(__("messages.statuscreate"))->success();
        return redirect()->route("task_statuses.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view("status.edit", compact("taskStatus"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskStatusRequest  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateTaskStatusRequest $request,
        TaskStatus $taskStatus
    ) {
        $data = $request->validated();
        $taskStatus->update($data);
        flash(__("messages.statusedit"))->success();
        return redirect()->route("task_statuses.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if (!$taskStatus->tasks()->exists()) {
            $taskStatus->delete();
            flash(__("messages.statusdel"))->success();
            return redirect()->route("task_statuses.index");
        } else {
            flash(__("messages.statuserror"))->error();
            return redirect()->route("task_statuses.index");
        }
    }
}
