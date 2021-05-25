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


    
}
