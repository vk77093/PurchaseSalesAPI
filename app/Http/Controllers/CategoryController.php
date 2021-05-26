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
}
