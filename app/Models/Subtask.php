<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subtask extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_completed',
        'task_id'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    protected static function booted()
    {
        static::updated(function ($subtask) {
            $subtask->task->load('subtasks')->updateStatusBasedOnSubtasks();
        });

        static::created(function ($subtask) {
            $subtask->task->load('subtasks')->updateStatusBasedOnSubtasks();
        });

        static::deleted(function ($subtask) {
            $subtask->task->load('subtasks')->updateStatusBasedOnSubtasks();
        });
    }
}
