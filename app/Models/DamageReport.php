<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamageReport extends Model
{
    protected $table = 'damage_reports';
    
    protected $fillable = [
        'user_id',
        'user_name',
        'purchase_id',
        'product_id',
        'product_name',
        'supplier_name',
        'damage_description',
        'damage_quantity',
        'status',
        'is_read',
    ];
    
    protected $casts = [
        'is_read' => 'boolean',
        'damage_quantity' => 'integer',
    ];
    
    public function user()
    {
        return $this->belongsTo(UserManagement::class, 'user_id');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}