<?php

namespace App\Models;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'supplier_name', 
        'email', 
        'contact_number', 
        'address', 
        'contact_person'
        ];

    public function products(){
        return $this->hasMany(Product::class, 'supplier_id');
    }

    public function purchases(){
        return $this->hasMany(Purchase::class, 'supplier_id');
    }
    public function setContactNumberAttribute($value)
    {
        $cleaned = preg_replace('/[^0-9\s\(\)\+-]/', '', $value);
        $this->attributes['contact_number'] = $cleaned;
    }
}
