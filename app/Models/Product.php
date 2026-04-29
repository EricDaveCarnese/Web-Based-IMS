<?php

namespace App\Models;

use App\Models\Category;
use App\Models\PurchaseDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{   
    use SoftDeletes;
    
    protected $table = 'products';
    
    protected $fillable = [
        'product_name',
        'category_id',
        'supplier_id',
        'description',
        'price',
        'quantity',
        'min_stock_level',
        'deleted_by'
    ];
    
    protected $dates = ['deleted_at'];
    
    // Relationship to get who deleted the product
    public function deletedBy()
    {
        return $this->belongsTo(UserManagement::class, 'deleted_by');
    }

    protected $casts = [
        'price'             => 'decimal:2',
        'quantity'          => 'integer',
        'min_stock_level'   => 'integer'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }  
    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function saleDetails(){
        return $this->hasMany(SaleDetail::class, 'product_id');
    }
    public function purchaseDetails(){
        return $this->hasMany(PurchaseDetail::class, 'product_id');
    }
    public function isLowStock(){
        return $this->quantity <= $this->min_stock_level;
    }

    public function updateStock($quantity, $operation = 'subtract'){

        if ($operation === 'subtract'){
            if ($this->quantity - $quantity < 0){
                throw new \Exception('Insufficient stock for ' . $this->product_name);
            }
            $this->quantity -= $quantity;
        } else {
            $this->quantity += $quantity;
        }
        $this->save();
        return $this->isLowStock();
    }
}
