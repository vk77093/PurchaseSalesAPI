<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;

class BuyerSellerController extends Controller
{
    public function index($id){
$buyer=Buyer::find($id);
//here we with used the eggar loadin with nesting on
// product.seller as it has that realtion
$sellerData=$buyer->transaction()->with('product.seller')->get();
// by using above method we are getting both buyer and seller but we only want seller
// so we are now using pluck method
$sellerData2=$sellerData->pluck('product.seller');
// by using above method we are getting dublicate seller with products that
//so that we can use unique method with values for
// recreating the index again so that we get the data unique
// but not the null values
$seller=$sellerData2->unique('id')->values();
return response()->json(['data'=>$seller]);
    }
}
