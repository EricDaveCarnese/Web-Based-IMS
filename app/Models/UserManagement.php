<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserManagement extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user_management';
    
    protected $fillable = [
        'fullname', 'email', 'role', 'password',
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    public function isUser()
    {
        return $this->role === 'user';
    }
    
    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id');
    }
    
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'user_id');
    }
}