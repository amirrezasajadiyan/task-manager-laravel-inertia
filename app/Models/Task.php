<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'user_id'
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function updateStatusBasedOnSubtasks()
    {
        if ($this->subtasks->count() > 0) {
            $allCompleted = $this->subtasks->every('is_completed', true);
            $this->update(['status' => $allCompleted ? 'done' : 'in_progress']);
        }
    }
}
