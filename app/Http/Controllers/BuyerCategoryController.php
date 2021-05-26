<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;

class BuyerCategoryController extends Controller
{
    public function index($id){
        $buyer=Buyer::find($id);
        //for obtaining the all the categoriee where buyer make
        // any kind of purchase
        $seller=$buyer->transaction()->with('product.category')
        ->get()->pluck('product.category')->collapse()
        ->unique('id')->values();
        return response()->json(['data'=>$seller]);
    }
}
