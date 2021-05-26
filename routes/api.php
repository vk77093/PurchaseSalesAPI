<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
use App\Http\Controllers\BuyerController;
Route::resource('buyers', BuyerController::class,['only'=>['index','show']]);

use App\Http\Controllers\CategoryController;
Route::resource('categories', CategoryController::class,['except'=>['create','edit']]);

use App\Http\Controllers\ProductController;
Route::resource('products', ProductController::class,['only'=>['index','show']]);

use App\Http\Controllers\SellerController;
Route::resource('seller', SellerController::class,['only'=>['index','show']]);

use App\Http\Controllers\TransactionController;
Route::resource('transaction', TransactionController::class,['only'=>['index','show']]);

use App\Http\Controllers\UserController;
Route::resource('users', UserController::class,['except'=>['create','edit']]);

use App\Http\Controllers\TransactionCategoryController;
Route::resource('transaction/{id}/categories', TransactionCategoryController::class,['only'=>['index']]);
use App\Http\Controllers\TransactionSellerController;
//Route::get('transactionsseller', [TransactionSellerController::class,'index']);
Route::resource('transaction/{id}/seller', TransactionSellerController::class,['only'=>['index']]);

use App\Http\Controllers\BuyerTransactionController;
Route::resource('buyers/{id}/transaction', BuyerTransactionController::class,['only'=>['index']]);

use App\Http\Controllers\BuyerProductController;
Route::resource('buyers.products', BuyerProductController::class,['only'=>['index']]);

use App\Http\Controllers\BuyerSellerController;
Route::resource('buyers.seller', BuyerSellerController::class,['only'=>['index']]);

use App\Http\Controllers\BuyerCategoryController;
Route::resource('buyers.categories', BuyerCategoryController::class,['only'=>'index']);

Route::get('categories/{id}/products', [CategoryController::class,'categoryProduct']);
Route::get('categories/{id}/seller',[CategoryController::class,'categorySeller']);
Route::get('categories/{id}/transaction',[CategoryController::class,'categoryTransaction']);
Route::get('categories/{id}/buyers',[CategoryController::class,'categoryBuyer']);