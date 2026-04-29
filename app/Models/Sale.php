<?php

namespace App\Models;

use App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'user_id',
        'sale_date',
        'status',
        'total_amount'
    ];

    protected $casts = [
        'sale_date'    => 'datetime',  // CHANGE THIS from 'date' to 'datetime'
        'total_amount' => 'decimal:2'
    ];

    public function user(){
        return $this->belongsTo(UserManagement::class, 'user_id');
    }
    
    public function saleDetails(){
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }
    
    public function calculatedTotal(){
        $this->total_amount = $this->saleDetails->sum('subtotal');
        $this->save();
        return $this->total_amount;
    }
}