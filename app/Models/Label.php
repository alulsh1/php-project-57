<?php

namespace App\Models;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $table = "labels";
    protected $fillable = ["name", "description"];

    public function getDateAsCarbonAttribute()
    {
        return Carbon::parse($this->created_at);
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class, "task_label");
    }
}
