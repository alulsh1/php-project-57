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

    public function create()
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();
        return view("task.create", compact("statuses", "users", "labels"));
    }

    public function store(TaskStoreRequest $request)
    {
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

    public function show(Task $task)
    {
        return view("task.show", compact("task"));
    }

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

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $data = $request->validated();
        $labels = $request->labels ?? [];
        $task->update($data);
        $task->labels()->sync(array_diff($labels, [null]));
        flash(__("messages.taskupdate"))->success();
        return redirect()->route("tasks.index");
    }

    public function destroy(Task $task)
    {
        $task->labels()->detach();
        $task->delete();
        flash(__("messages.taskdelete"))->success();
        return redirect()->route("tasks.index");
    }
}
