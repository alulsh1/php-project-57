<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $table = "tasks";
    protected $fillable = [
        "name",
        "description",
        "status_id",
        "assigned_to_id",
        "created_by_id",
    ];

    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function userTask()
    {
        return $this->belongsTo(User::class, "assigned_to_id", "id");
    }
    public function userCreate()
    {
        return $this->belongsTo(User::class, "created_by_id", "id");
    }

    public function getDateAsCarbonAttribute()
    {
        return Carbon::parse($this->created_at);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, "task_label");
    }
}
