<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $fillable = [
        'user_id', 
        'user_name', 
        'action', 
        'module', 
        'description', 
        'old_data', 
        'new_data', 
        'ip_address'
    ];
    
    public function user()
    {
        return $this->belongsTo(UserManagement::class, 'user_id');
    }
}
