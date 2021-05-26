<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionSellerController extends Controller
{
    public function index($id){
        $transaction=Transaction::find($id);
        $seller = $transaction->product->seller;
        return response()->json($seller);
    }
}
