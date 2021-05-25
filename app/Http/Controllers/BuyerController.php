<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;


class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyer=Buyer::has('transaction')->get();
        return response()->json(['data'=>$buyer],200);
    }
public function show($id){
$buyer=Buyer::has('transaction')->findOrFail($id);
return response()->json(['data'=>$buyer],200);
}
    
}
