<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','description','product_id',
    ];

    public function product(){
        return $this->belongsToMany(Product::class);
    }
}
