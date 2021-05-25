<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;




class Transaction extends Model
{
    use HasFactory,softDeletes;
protected $dates=['deleted_at'];
    protected $fillable = [
'quantity','product_id','buyer_id',
    ];

    public function buyer(){
        return $this->belongsTo(Buyer::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

    
}
