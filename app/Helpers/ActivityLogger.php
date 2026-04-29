<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($action, $module, $description, $oldData = null, $newData = null)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->fullname,
                'action' => $action,
                'module' => $module,
                'description' => $description,
                'old_data' => $oldData ? json_encode($oldData) : null,
                'new_data' => $newData ? json_encode($newData) : null,
                'ip_address' => request()->ip(),
            ]);
        }
    }
}