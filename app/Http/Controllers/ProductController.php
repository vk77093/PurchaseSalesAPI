<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProductController extends TraitController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Product::all();
        return $this->showAll($product);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'name'=> 'required',
            'description' => 'required',
            
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product,$id)
    {
      
        return $this->showOne($product::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /** calling from Transaction Tables
     * ProductTransaction --- Geting the list of all products
     * which have the transaction associated with them
     */
    public function productTransaction($id){
$product=Product::find($id);
//transaction from product model
$transaction=$product->transaction;
return response()->json(['data'=>$transaction]);
    }
/**
 * productBuyer-- for getting the list of all the buyers
 * only from the specified product
 */
public function productBuyer($id){
    $product=Product::find($id);
    $buyers=$product->transaction()->with('buyer')
    ->get()->pluck('buyer')->unique('id')->values();
    return response()->json(['data'=>$buyers]);
   
}
/**
 * productCategory -- get product category list from the Product
 * Category from the table Category_product
 * and perform all tasks for that
 */
public function productCategory($id){
    $products =Product::find($id);
    // category form the products model hasMany
    $category =$products->category;
    return response()->json(['data'=>$category]);
}
/**
 * productCategoryUpdate -- here we will update the category and category
 * add the category in the that category_product table
 * for that their is three methods is available
 * attach,sync,syncWithoutDetaching
 */
public function productCategoryUpdate(Request $request,Product $product,Category $category){
    // $product=Product::find($id);
    // $categorys=Category::find($catId);
    $product->category()->syncWithoutDetaching([$category->id]);
    return response()->json(['data'=>$product->category]);
}
 
/**
 * productCategoryDelete--
 */
public function productCategoryDelete(Product $product,Category $category){
    if(!$product->category()->find($category->id)){
        return response()->json(['message'=>'That is not a category for that product',$product->name]);
    }
    $product->category()->detach($category->id);
    return response()->json(['data'=>$product->category]);
}
/**productBuyerUpdate---
 * here we will update the details of the product
 * the buyers only pass the quantity 
 */
public function productBuyerUpdate(Request $request, $proId,$buyerId){
$product=Product::find($proId);
$buyer=User::find($buyerId);
if($buyer->id == $product->seller_id){
    return response()->json(['message' =>'The buyer must be different from seller',422]);
}
if(!$buyer->isVerified()){
    return response()->json(['message' =>'The buyer must be verified',409]);
}
if(!$product->seller->isVerified()){
    return response()->json(['message' =>'The seller must be verified']);
}
if(!$product->isAvailable()){
  return response()->json(['message' =>'The product is not available']);
}
if($product->quantity <$request->quantity){
    return response()->json(['message' =>'The product does not have enough units
    for update']);
}
return DB::transaction(function ()use($request,$product,$buyer) {
  $product->quantity -= $request->quantity;
  $product->save();
  $transaction=Transaction::create([
      'quantity' =>$request->quantity,
      'buyer_id'=>$buyer->id,
      'product_id'=>$product->id,

  ]);
  return response()->json(['data'=>$transaction]);
});
}
/**
 * now we are doing the event if the product quantity is 0 then
 * the product automatically become unavailable
 * for that we need to go to app service provide and inside 
 * boot methods we need to define the values
 */
}
