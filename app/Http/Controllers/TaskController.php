<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Label;
use Illuminate\Http\RedirectResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

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
        $statuses = TaskStatus::all()->mapWithKeys(function ($item, $key) {
            return [$item["id"] => $item["name"]];
        });

        $users = User::all()->mapWithKeys(function ($item, $key) {
            return [$item["id"] => $item["name"]];
        });

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact("status_id"),
                AllowedFilter::exact("created_by_id"),
                AllowedFilter::exact("assigned_to_id"),
            ])
            ->orderBy("id")
            ->paginate(10);

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
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => "required | unique:tasks",
                "description" => "nullable|string",
                "status_id" => "required",
                "assigned_to_id" => "nullable|integer",
            ],
            [
                "name.unique" => "«адача с таким именем уже существует",
            ]
        );

        $data = $request->validated();
        $user = Auth::user();
        $labels = $request->labels;

        $task = new Task();
        $task = $user->createdTasks()->make();
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
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make(
            $request->all(),
            [
                //   'name' => 'required | unique:tasks,name,'.$this->task->id,

                "name" => [
                    "required",
                    Rule::unique("tasks")->ignore($this->task->id),
                ],
                "description" => "nullable|string",
                "status_id" => "required",
                "assigned_to_id" => "nullable|integer",
            ],
            [
                "name.unique" => "«адача с таким именем уже существует",
            ]
        );

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
        $task->labels()->detach();
        $task->delete();
        flash(__("messages.taskdelete"))->success();
        return redirect()->route("tasks.index");
    }
}
