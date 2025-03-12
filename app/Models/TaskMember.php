<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskMember extends Model
{
    protected $guarded = [];

    /* ============================================
    RELATIONSHIPS
    =============================================== */
    public function member() {
        return $this->belongsTo(Member::class);
    }
}
