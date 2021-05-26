<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seller=Seller::has('product')->get();
        return response()->json(['data'=>$seller],200);
    }
    public function show($id){
        $seller=Seller::has('product')->findOrFail($id);
        return response()->json(['data'=>$seller],200);
    }
/**
 *sellerTransaction --list of transactions for specific seller
 */
public function sellerTransaction($id){
    $seller=Seller::findOrFail($id);
    $transactions=$seller->product()->whereHas('transaction')
    ->with('transaction')->get()
    ->pluck('transaction')->collapse();
    return response()->json(['data'=>$transactions],200);
}
 /**
  * sallerCategory- for showing the category for the
  * specific seller
  */
  public function sallerCategory($id){
      $seller=Seller::find($id);
      $category=$seller->product()->whereHas('category')
      ->with('category')->get()->pluck('category')
      ->collapse()->unique()->values();
      if(is_null($seller)){
          return response()->json(['message'=>'No Data is found for that']);
      }
      return response()->json(['data'=>$category]);
  }
/**
 * sellerBuyer-- for obtain the buyers for specific seller
 */
public function sellerBuyer($id){
    $seller=Seller::find($id);
    $buyers=$seller->product()->whereHas('transaction')
    ->with('transaction.buyer')->get()
    ->pluck('transaction')->collapse()
    ->pluck('buyer')->unique('id')->values();
    return response ()->json(['data'=>$buyers]);

}
  /**
   * sellerProduct- getting the all the seller products
   */
    public function sellerProduct($id){
        $seller=Seller::find($id);
        $products=$seller->product;
        return response()->json(['data'=>$products]);
    }
}
