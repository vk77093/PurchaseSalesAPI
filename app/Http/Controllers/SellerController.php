<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Validator;
use App\Exceptions\Handler;

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
    /**
     * sellerProductStore-- it will allow you to store the product
     * assocaiated with specific seller
     * we need to use the User model as the seller is assocaiated with the use
     * and if we not use the user and call the seller then we will not be able to
     * create the product in first phase as he will not a user.
     */
    public function sellerProductStore(Request $request,$id){
$user =User::find($id);
$rules=[
'name' => 'required',
'description' => 'required',
'quantity' => 'required|integer',
];
$validate =Validator::make($request->all(),$rules);
if($validate->fails()){
    return response()->json($validate->errors(),400);
}
$data=$request->all();
$data['status']=Product::UNAVAILABLE_PRODUCT;
$data['image']='1.jpg';
$data['seller_id']=$user->id;
$product=Product::create($data);
return response()->json(['data'=>$product],200);

    }
    /**
     * Updating the seller product list
     */
    public function sellerProductUpdate(Request $request,$id,$proID){
        $user =Seller::find($id);
        $product = Product::find($proID);
        $rules=[
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer',
            ];
            $validate =Validator::make($request->all(),$rules);
            if($validate->fails()){
                return response()->json($validate->errors(),400);
            }
            $this->checkSeller2($user,$product);
            $product->fill($request->only([
                'name','description','quantity',
            ]));
            if($request->has('status')){
                $product->status=$request->status;
                if($product->isAvailable() && $product->category()->count()==0){
                    return response()->json('The mentioned product must
                    need to be have atleast one category',409);
                }
            }
            if($product->isClean()){
                return response()->json(['message'=>'You need to specify the value for update'],422);
            }
            $product->update();
            return response()->json(['data'=>$product],200);
            
    }
    /**
     * Checking wether the user is registered as seller
     * or not through that method and will be used in further
     */
    // protected function checkSeller($sellerId,$productsId){
    //     $productsIdget=Product::find($productsId);
    //     $sellerIdGet=Seller::find($sellerId);
    //     if($sellerIdGet !== $productsIdget->sellerIdGet){
    //        // throw new HttpException(422,'The specified seller is not a seller');
    //     }

    // }
    protected function checkSeller2(Seller $seller,Product $product){
        if($seller->id !=$product->sellerId){
            //throw new HttpException('The specified seller is not a seller');   
        }
    }
    /**
     * sellerProductDelete-- we will delete the seller product
     * from the list
     */
    public function sellerProductDelete($id,$proID){
        $seller =Seller::find($id);
        $product = Product::find($proID);
        $this->checkSeller2($seller,$product);
        $product->delete();
        return response()->json(['data'=>$product]);
    }
}
