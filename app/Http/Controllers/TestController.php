<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderProduct;
use App\Models\OrderDetail;
use App\Models\Product;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    //一對一關聯資料庫sample  
    public function test()
    {
        
        
//         //取得id為1的資料
//         $orderDetail = OrderDetail::find(1);
        
//         //將資料表已經設定好的關聯商品
//         $produts = $orderDetail->product;
        
//         dd($orderDetail,$produts->product_name);
        
        
        //在 orderProduct table取得id為1 的資料
        $orderProduct = OrderProduct::find(1);
        $test = OrderProduct::get();
        
        //取得ID為1所對應的user資料
        $user = $orderProduct->user;
        //取得id為1所對應的table deatails資料
        $details = $orderProduct->details;
        
        
        //秀出三個關聯的資料
        dd($orderProduct,$user , $details);
    }

     
    
}
