<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public static function changeTaskStatus($taskId, $status) {
        Task::where('id', $taskId)->update(['status' => $status]);
    }

    /* ============================================
    RELACIONES
    =============================================== */
    // Relación con TaskMember (uno a muchos)
    public function taskMembers() {
        return $this->hasMany(TaskMember::class);
    }
}
