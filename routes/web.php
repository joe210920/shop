<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

use App\Http\Middleware\ShopCarMiddle;
use App\Http\Middleware\MemberMiddle;
use App\Http\Middleware\ProductMiddle;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//測試
Route::get('member/test', "MemberController@test");
//member登入頁面
Route::get('member/index', "MemberController@index");
//登入頁面輸入完後，到後台驗證
Route::post('member/login', "MemberController@login");

//成員-用中介層去阻止使用者不當登入個頁面的狀況，若不正常登入就會導到頁面
Route::middleware([MemberMiddle::class])->group(function () {
    //增加成員
    Route::get('member/addMember', "MemberController@addMember");
    //秀出所有成員
    Route::get('member/showMember', "MemberController@showMember");    
    //修改成員資料
    Route::post('member/editMember', "MemberController@editMember");
    //可使用四大(查詢、新增、修改、刪除)功能
    Route::resource('member', "MemberController");
        
});

//商品管理頁面
Route::get('pdt/index', "ProductController@index");
//在登入頁面輸入帳號密碼，使用loginProduct方法驗證使用者
Route::post('pdt/loginProduct','ProductController@loginProduct');
//商品操作頁面用middleware去阻止使用者不當登入個頁面的狀況，若不正常登入就會導到登入頁面
Route::middleware([ProductMiddle::class])->group(function () {
    //管理商品頁面    
    Route::get('pdt/manageProduct', "ProductController@manageProduct");
    //秀出商品
    Route::get('pdt/showProduct', "ProductController@showProduct");
    //修改商品
    Route::get('pdt/editProduct', 'ProductController@editProduct');
    //可使用四大(查詢、新增、修改、刪除)功能
    Route::resource('pdt', "ProductController"); 
});

//登入購物車頁面
Route::get('shopCar/index', "ShopCarController@index");
//驗證使用者
Route::post('shopCar/loginShopCar', "ShopCarController@loginShopCar");
//購物車-用中介層去阻止使用者不當登入個頁面的狀況，若不正常登入就會導到頁面
Route::middleware([ShopCarMiddle::class])->group(function () {
//秀出可購買的商品  
Route::get('shopCar/showShop', "ShopCarController@showShop");
    //新增購物車裡的商品
    Route::get('shopCar/addShopCar/{id}/{shopNumber}', "ShopCarController@addShopCar");
    //顯示購物車裡的商品
    Route::get('shopCar/shopCarList', "ShopCarController@shopCarList");
    //將要購物車裡的商品取消
    Route::post('shopCar/cancel/{id}', "ShopCarController@cancel");
    //將購物車裡得的商品結帳
    Route::get('shopCar/checkout', "ShopCarController@checkout");
    //可使用四大(查詢、新增、修改、刪除)功能
    Route::resource('shopCar', "ShopCarController");
    
    //訂單畫面
    //顯示訂單
    Route::get('order/showOrder', "OrderController@showOrder");
    //顯示單筆訂單的明細
    Route::get('order/showDetails/{id}', "OrderController@showDetails");
    ////可使用四大(查詢、新增、修改、刪除)功能
    Route::resource('order', "OrderController");

});
//mo購物車平台(前後台分離)

//購物首頁
Route::get('moShop/index', "moShopController@index");
//購物登入
Route::get('moShop/login', "MemberController@index");
//API 檢查登入
Route::post('moShop/checkAndLogin', "MemberController@checkAndlogin");

//註冊頁面
Route::get('moShop/register', "MemberController@register");
//顯示購買商品
Route::get('moShop/showShop', "ShopCarController@shopShop");

//修改會員
Route::middleware([MemberMiddle::class])->group(function(){
    Route::get('moShop/editMember', "MemberController@editMember");
    
});

//for test
Route::get('test', "TestController@test");
