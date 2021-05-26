<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;

class BuyerProductController extends Controller
{
    public function index($id){
$buyer = Buyer::find($id);
//here used eggar loading
//$product = $buyer->transaction()->with('product')->get();
//only get the products details
$product = $buyer->transaction()->with('product')->get()->pluck('product');
return response()->json(['data'=>$product]);
    }
}
