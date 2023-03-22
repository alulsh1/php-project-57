<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\TaskStatus;
use App\Models\User;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Label;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, "task");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statuses = TaskStatus::all()->pluck("name", "id");

        $users = User::all()->pluck("name", "id");

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters(["status_id", "created_by_id", "assigned_to_id"])
            ->paginate(15)
            ->appends(request()->query());

        $query = $request->filter;

        return view(
            "task.index",
            compact("statuses", "users", "tasks", "query")
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();
        return view("task.create", compact("statuses", "users", "labels"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();
        $data["created_by_id"] = auth()->user()->id;
        $labels = $request->labels;

        $task = new Task();
        $task->fill($data);
        $task->save();
        $task->labels()->attach(array_diff($labels, [null]));
        flash(__("messages.taskcreate"))->success();
        return redirect()->route("tasks.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view("task.show", compact("task"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $statuses = TaskStatus::all()->mapWithKeys(function ($item, $key) {
            return [$item["id"] => $item["name"]];
        });

        $users = User::all()->mapWithKeys(function ($item, $key) {
            return [$item["id"] => $item["name"]];
        });
        $labels = Label::all()->mapWithKeys(function ($item, $key) {
            return [$item["id"] => $item["name"]];
        });
        return view(
            "task.edit",
            compact("task", "statuses", "users", "labels")
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        $data = $request->validated();
        $labels = $request->labels ?? [];
        $task->update($data);
        $task->labels()->sync(array_diff($labels, [null]));
        flash(__("messages.taskupdate"))->success();
        return redirect()->route("tasks.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if ($task) {
            $task->labels()->detach();
            $task->delete();
        }
        flash(__("messages.taskdelete"))->success();
        return redirect()->route("tasks.index");
    }
}
