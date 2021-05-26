<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use HasFactory;
    use softDeletes;
    protected $dates=['deleted_at'];
    protected $fillable=[
        'name','description','product_id',
    ];
    protected $hidden=['pivot'];

    public function product(){
        return $this->belongsToMany(Product::class);
    }
}
