<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory,softDeletes;
    protected $dates=['deleted_at'];

    const AVAILABLE_PRODUCT='available';
    const UNAVAILABLE_PRODUCT='unavailable';
    protected $hidden=['pivot'];
    protected $fillable = [
        'name','description','quantity','status','seller_id','image',
    ];
    public function isAvailable(){
        return $this->status ==Product::AVAILABLE_PRODUCT;
    }
    
    public function category(){
        return $this->belongsToMany(Category::class);
    }
    public function seller(){
        return $this->belongsTo(Seller::class);
    }
    // public function categories(){
    //     return $this->belongsTo(Category::class);
    // }
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
}
