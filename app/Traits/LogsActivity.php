<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    protected function log(string $action, ?string $description = null, ?Model $subject = null): void
    {
        $user = request()->user();

        ActivityLog::create([
            'user_id' => $user?->id,
            'role' => $user?->role,
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->id,
            'ip' => request()->ip(),
        ]);
    }
}
