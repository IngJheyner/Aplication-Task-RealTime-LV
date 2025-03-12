<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Project extends Model
{

    protected $guarded = [];

    public static function createSlug($name)
    {
        $code = Str::random(10) . time();
        $slug = Str::slug($name) . '-' . $code;
        return $slug;
    }

    /* ============================================
    RELACIONES
    =============================================== */
    public function task_progress(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(TaskProgress::class, 'project_id', 'id');
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class);
    }

}
