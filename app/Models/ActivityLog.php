<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id', 'role', 'action', 'description',
        'subject_type', 'subject_id', 'ip',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}
