<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockReport extends Model
{
    protected $table = 'stock_reports';
    protected $fillable = [
    'user_id',
    'user_name',
    'product_id',
    'product_name',
    'current_stock',
    'min_stock_level',
    'message',
    'status',
    'user_notified',
    'admin_response',
    'purchase_id',
    'notify_users'
];
    
     protected $casts = [
        'user_notified' => 'boolean',
        'notify_users' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function user()
    {
        return $this->belongsTo(UserManagement::class, 'user_id');
    }
}
