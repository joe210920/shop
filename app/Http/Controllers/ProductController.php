<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Member;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //顯示loginProduct頁面，於前後台分離後已廢棄此方法
    public function index()
    {
        return view('loginProduct');
    }
    
    //顯示manageProductu頁面，於前後台分離後已廢棄此方法
    public function manageProduct() 
    {
        return view('manageProduct');
    }
    
    //顯示商品資訊,顯示在showProduct頁面上
    public function showProduct() {
             
        $products = new Product();
        $products = Product::get();
            
        return view('showProduct', ["products" => $products]);
      
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
    //新增商品資料
    public function store(Request $request)
    {
        $name= $request->name;
        $stock = $request->stock;
        $price = $request->price;
        $img = $request->img;
            
        $imgPath = "";
        if(isset($img)) {
            $imgPath = $img->store('images', "public");       
        } else {
            $imgPath = "無照片";
        }
        
        $product = new Product();
        $product->name = $name;
        $product->stock = $stock;
        $product->price = $price;
        $product->img_path = $imgPath;
            
        $product->save();
            
        return redirect('pdt/showProduct');         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //將前端傳來的id當作搜尋的key，找出商品，之後秀在editProduct上，供使用者修改
    public function edit($id)
    {
        $product = Product::find($id);
        return view("editProduct", ["product" => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //更新資料
    public function update(Request $request, $id)
    {   
        $product = Product::find($id);
        $newImg = $request->img;
        $OriginalImg = $product->img_path;
        
        //判斷商品若有上傳新照片，就刪除舊照片，然後更新照片及資料
        $imgPath = null;
        if(isset($newImg)) { 
            
            $imgPath = $newImg->store('images' ,"public");
            $delImg = Storage::disk('public')->delete($OriginalImg);
            $product -> name = $request -> name;
            $product -> stock = $request -> stock;
            $product -> price = $request -> price;
            $product -> img_path = $imgPath;
        
        } else {
            
            $product -> name = $request -> name;
            $product -> stock = $request -> stock;
            $product -> price = $request -> price;
            
        }
                 
        $product -> update();
        return redirect('pdt/showProduct');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {   
        //找到此id的商品，連同上存在public裡的照片刪除   
        $product = product::find($id);
        $delImg = Storage::disk('public')->delete($product->img_path);
        
        $product->destroy($id);
 
        return redirect('pdt/showProduct');
    }
    
   //驗證使用者(此方法在前後台分離後，已不使用)
   public function loginProduct(Request $request) 
   {      
       $account =$request->account;
       $password = $request->password;
       //@TODO 
       $isCheck = Member::where('account', $account)->where('password', $password)->exists();
       
       /*若驗證成功，就將session加入member裡，成功就轉至 pdt/manageProduct(管理商品頁面)，
        * 失敗就導回登入頁面，並將session裡msg訊息設定為登入失敗，顯示在登入頁面上
        */
       
       if($isCheck) {
           $result = Member::where('account', $account)->first();
          
           session(['member' => $result]);
           
           return redirect('pdt/manageProduct');
       } else {
           $msg = "登入失敗，請重新輸入帳號密碼";
           
           session(['msg' => $msg]);
           
           return redirect('pdt/index');
       }
   }
}
