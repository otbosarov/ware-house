<?php

use App\Http\Controllers\BrendController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InputProductsController;
use App\Http\Controllers\OutputProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProductVariantDetailsController;
use App\Http\Controllers\UploadToExcelController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/register',[UserController::class, 'register']);
Route::post('user/login',[UserController::class,'login']);

Route::group(['middleware' => 'auth:sanctum'],function(){

    Route::put('user/update/{id}',[UserController::class,'update']);
    Route::get('user_info',[UserController::class,'get_profil']);
    
    Route::get('brend/show',[BrendController::class,'index']);
    Route::post('brend/create',[BrendController::class,'store']);

    Route::get('category_show',[CategoryController::class,'index']);
    Route::post('category_create',[CategoryController::class,'store']);

    Route::get('product_show',[ProductController::class,'index']);
    Route::post('product_create',[ProductController::class,'store']);
    Route::put('product_update/{id}',[ProductController::class,'update']);

    Route::get('product_variant_show',[ProductVariantController::class, 'index']);
    Route::post('product_variant_create',[ProductVariantController::class,'store']);
    Route::put('product_variant_update/{id}',[ProductVariantController::class,'update']);

    Route::get('input_product_show',[InputProductsController::class,'index']);
    Route::post('input_product_create',[InputProductsController::class,'store']);
    Route::put('input_product_update/{id}',[InputProductsController::class,'update']);

    Route::get('product_variant_details_show',[ProductVariantDetailsController::class,'index']);
    Route::put('product_variant_details_update/{id}',[ProductVariantDetailsController::class,'update']);

    Route::get('out_product_show',[OutputProductController::class,'index']);
    Route::post('output_product_create',[OutputProductController::class,'store']);

    Route::get('input_products_excel',[UploadToExcelController::class,'InputProductsExcel']);
    Route::get('output_products_excel',[UploadToExcelController::class,'OutputProductsExcel']);
    Route::get('product_variant_details_excel',[UploadToExcelController::class,'ProductVariantDetailsExcel']);

    Route::resource('brend',BrendController::class);
    Route::resource('category',CategoryController::class);
    Route::resource('products',ProductController::class);
    Route::resource('product_variants',ProductVariantController::class);
    Route::resource('input_products',InputProductsController::class);
    Route::resource('product_variant_details',ProductVariantDetailsController::class);
    Route::resource('output_products',OutputProductController::class);
 });
