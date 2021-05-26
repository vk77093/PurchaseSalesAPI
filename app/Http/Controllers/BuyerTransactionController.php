<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;

class BuyerTransactionController extends Controller
{
    public function index($id){
$buyers=Buyer::find($id);
$transaction=$buyers->transaction;
return response()->json($transaction);
    }
}
