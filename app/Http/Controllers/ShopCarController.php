<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Member;
use App\Models\OrderDetail;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;

class ShopCarController extends Controller
{
    //測試
    public function test() 
    {
        //DB::enableQueryLog();//要求mysql log出現
        //秀出要求mysql log;
        //$products = Product::where('id', 24)->get();
        //dd(DB::getQueryLog()) 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('loginShopCar');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
    public function showShop()
    { 
        $products = new Product();
        $products = Product::get();
        
        return view('showShop', ['products' => $products]);
    }
    
    //驗證使用者(此方法在前後台分離後，已不使用)
    public function loginShopCar(Request $request)
    {
        $account = $request->account;
        $password = $request->password;
        
        //@TODO 已修正
        $isCheck = Member::where('account', $account)->where('password', $password)->exists();
        
        /*若驗證成功，就將session加入member裡，成功就轉至 pdt/manageProduct(管理商品頁面)，
         * 失敗就導回登入頁面，並將session裡msg訊息設定為登入失敗，顯示在登入頁面上
         */
        if($isCheck) {
            $result = Member::where('account', $account)->first();
            session(['member' => $result]);
           
            return redirect('shopCar/showShop');
        } else {
            $msg = "登入購物車失敗";
            session(['msg' => $msg]);
            return redirect('shopCar/index');
            
        }

    }
    
    //用session 的功能，將商品加入session裡，暫時儲存
    public function addShopCar($id, $qty) 
    {
        $product = Product::find($id);
        $qty = intval($qty);
        
        if(session()->get("shopCarProducts") != null) {
            
            $shopCarProducts = session()->get("shopCarProducts");
            $flag = false;
            $i = 0;
            foreach($shopCarProducts as $scpdt) {
               
                if($id == $scpdt->id) {
                   
                    if($product->stock - $scpdt->qty >= $qty) {
                        
                        $scpdt->qty += $qty;
                        
                        session()->put("shopCarProducts.$i", $scpdt);
                        $flag = true;
                        
                        return redirect('shopCar/showShop'); 
                    }   
                }
                $i++;
            }
            
            if(!$flag) {
                
                $product->qty = $qty;
                session()->push("shopCarProducts", $product);
                return redirect('shopCar/showShop');
            }
                      
        } else {
            
            $product -> qty = $qty;
            
            session()->push("shopCarProducts", $product);
            
            return redirect('shopCar/showShop');
        }
    }
    
    //列出加入購物車裡的商品
    public function shopCarList() {
       
        if(session()->get("shopCarProducts") == null) {
            
            session(['shopMsg' => "購物車無商品"]);
            
            return redirect('shopCar/showShop');
        } else
            return view('shopCarList');        
    }
    
    //取消訂購購物車裡的商品
    public function cancel($id) {
        
        $shopCarProducts = session()->get("shopCarProducts");
       
        foreach($shopCarProducts as $key=>$scpdt) {
            if($scpdt->id == $id) {
                
                unset($shopCarProducts[$key]);        
            }
        }
        
        if(count($shopCarProducts) == 0) {
            
            session(['shopMsg' => "購物車無商品"]);
            session()->put("shopCarProducts", $shopCarProducts);
            
            return redirect('shopCar/showShop');
        } else {
            
            session()->put("shopCarProducts", $shopCarProducts);
            
            return redirect('shopCar/shopCarList'); 
        }
    }
    //結帳
    public function checkout() 
    {
        $member = session()->get('member');
        $shopCarProducts = session()->get('shopCarProducts');
        
        $total = 0;
        foreach($shopCarProducts as $key=>$scpdt) {
            $price = $scpdt->price * $scpdt->qty;
           
            $total += $price;
            $scpdt->total = $price;
        }
        
        //將資料insert orderProduct裡面
        $orderProduct = new OrderProduct();
        $orderProduct->member_id = $member->id;
        $orderProduct->total = $total;
        $resultOrderProduct = $orderProduct->save();
  
        //將資料同步也insert到orderDetail table裡
        $retuleOrderDetail = false;
         
        foreach($shopCarProducts as $key=>$scpdt) {
           
            $orderDetail = new OrderDetail();
            //取得剛insert 進orderProduct資料表的id將之insert進去table
            $orderDetail->order_product_id = $orderProduct->id;
            $orderDetail->product_id = $scpdt->id;
            $orderDetail->qty = $scpdt->qty;
            $orderDetail->total = $scpdt->total;
            $resultOrderDetail = $orderDetail->save();
            
            //將庫存扣掉購買數量寫回products table stock欄位裡
            $product = Product::find($scpdt->id);
            $product->stock = $scpdt->stock - $scpdt->qty;
            $product->update();
        }                
        if($resultOrderProduct == $resultOrderDetail) {
            
            session(['orderMsg' => "store order success"]);
            //移除session裡的shopCarProducts
            session()->forget('shopCarProducts'); 
        } else 
            //將orderMsg訊息設定為store order fail
            session(['orderMsg' => "store order fail"]);
        
         return redirect('shopCar/showShop');
    }
    
}
