<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'report_date',
        'user_id',
        'tasks',
        'work_in_progress',
        'issues',
        'plans',
    ];

    protected $casts = [
        'report_date' => 'date',
        'tasks' => 'array',
        'work_in_progress' => 'array',
        'issues' => 'array',
        'plans' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
