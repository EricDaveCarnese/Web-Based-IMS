<?php

namespace App\Models;

use App\Models\PurchaseDetail;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';

    protected $fillable = [
        'user_id', 
        'supplier_id', 
        'purchase_date', 
        'status',
        'due_date',
        'batch_number',
        'original_price'
    ];

    protected $casts = [
        'purchase_date' => 'datetime'
    ];

    public function user(){
        return $this->belongsTo(UserManagement::class, 'user_id');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function purchaseDetails(){
        return $this->hasMany(PurchaseDetail::class, 'purchase_id');
    }

    public function complete(){
        foreach($this->purchaseDetails as $detail){
            $detail->product->updateStock($detail->quantity, 'add');
        }
        $this->status = 'completed';
        $this->save();
    }
}
