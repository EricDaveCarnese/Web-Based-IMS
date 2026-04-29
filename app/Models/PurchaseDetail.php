<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table = 'purchase_details';

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'cost_price'
    ];

    public function purchase(){
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
