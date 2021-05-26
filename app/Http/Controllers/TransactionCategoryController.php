<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionCategoryController extends Controller
{
    public function index($id){
$transaction=Transaction::find($id);
 $categoryData =$transaction->product->category;
return response()->json($categoryData);
// return response()->json(['hello i ']);


    }
}
