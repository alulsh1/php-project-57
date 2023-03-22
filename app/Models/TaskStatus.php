<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Task;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    public function getDateAsCarbonAttribute()
    {
        return Carbon::parse($this->created_at);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class, "status_id", "id");
    }
    public function task()
    {
        return $this->hasOne(Task::class, "status_id", "id");
    }
}
