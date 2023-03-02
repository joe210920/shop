<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderProduct;
use App\Models\OrderDetail;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
       //暫時沒有要寫
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //將訂單內定訂購的商品數量還回去商品庫存
        $goBackStocks = [];
            
        $orderDetails = OrderDetail::where('order_product_id', $id) -> get();
            
        foreach($orderDetails as $detail) {
            $goBackStocks[$detail->product_id] = $detail->qty;
        }
            
        $products = Product::get();
        
        //將取得的庫存一筆一筆加回去個商品庫存中
        foreach($goBackStocks as $key => $qty) 
        {
            foreach($products as $pdt) 
            {
               if($pdt->id == $key) 
               {
                   $product = Product::find($key);
                   $product -> stock = $pdt-> stock + $qty;
                   $product -> update();
               }
            }
        }
        //將訂單刪除
        $delOrder = OrderProduct::find($id);
        $delOrder->details()->delete();
        $delOrder->delete();
            
        return redirect('order/showOrder');
    }
    
    /*取出session裡的memeber物件裡的id,
     *用此id去篩選出相關訂單，顯示在showOrder
     */
    public function showOrder()
    {
        $memberId = session()->get('member')->id;    
        $orders = OrderProduct::where("member_id", $memberId)->get();
        
        return view('showOrder', ['orders' => $orders]);
    }
    
    /*
     * 在showOrderDetail頁面顯示details資料
     * 此關聯資料必須先在Models裡面做一對多關聯
     */
    public function showDetails($id) 
    {   
        $orderProduct = OrderProduct::find($id);
        $details = $orderProduct -> details;
        
        //將details裡的每一筆資料個別加入對應的商品資訊
        $i = 0;
        foreach($details as $detail) {
            $details[$i] -> product = $detail-> product;
            $i++;
        }
        return view('showOrderDetail', ['details' => $details]); 
    }
}
