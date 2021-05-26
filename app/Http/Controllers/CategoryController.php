<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Validator;


class CategoryController extends TraitController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category=Category::all();
        return $this->showAll($category);
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
        'name' => 'required',
        'description' => 'required',
    ];
    $validate=Validator::make($request->all(),$rules);
    if($validate->fails()){
        return $this->errorResponse($validate->errors(),400);
    }

    $category=Category::Create($request->all());
return $this->showOne($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category,$id)
    {
        
        return $this->showOne($category::find($id));
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
$category=Category::find($id);

        $rules=[
            'name' => 'required',
            'description' => 'required',
        ];
        $validate=Validator::make($request->all(),$rules);
        if($validate->fails()){
            return $this->errorResponse($validate->errors(),400);
        }
        $category->update($request->all());
        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $category=Category::find($id);
       $category->delete();
       return $this->showOne($category);
    }

    // addtional method for the Category related views

    //CategoryProduct -- for getting the list of products
    // for specific category
    public function categoryProduct($id){
        $category=Category::find($id);
        // return "Hello i will show the products
        // with specific category $id";
        $products=$category->product;
        // return $this->showAll($products);
        return response()->json(['data'=>$products]);
        //here the issue of pivot table is occuring that will
        // be remove at the category and products model
    }

    /****
     * CategorySeller-- for getting the list of seller
     * for the some specific category products
     */
public function categorySeller($id){
$category=Category::find($id);
$seller=$category->product()->with('seller')->get()
->pluck('seller')->unique('id')->values();
return response ()->json(['data'=>$seller]);

}
 /**
  *CategoryTransaction-- for getting the list of transactions
  * based on the specific category
   */   
  public function categoryTransaction($id){
     $category=Category::find($id);
     $transactions=$category->product()->whereHas('transaction') 
     ->with('transaction')->get()->pluck('transaction')
     ->collapse();
     return response()->json(['data'=>$transactions]);
  }
  /**
   * categoryBuyer-- for getting the list of all the buyers
   * for the specific category
   */
  public function categoryBuyer($id){
      $category=Category::find($id);
      $buyers=$category->product()->whereHas('transaction')
      ->with('transaction.buyer')->get()
      ->pluck('transaction')->collapse()
      ->pluck('buyer')->unique('id')->values();
      return response()->json(['data'=>$buyers]);
  }
}
