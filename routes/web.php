<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     return view('products');
// });


Route::get('/',[ProductController::class,'index'])->name('product.index');
Route::post('/fetch',[ProductController::class,'fetch'])->name('products.fetch');
Route::post('product/store',[ProductController::class,'store'])->name('product.store');
Route::get('products/{index}/edit',[ProductController::class,'edit'])->name('product.edit');
Route::put('product/update',[ProductController::class,'update'])->name('product.update');
