<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;


class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //首頁
    public function index()
    {
        return view('login');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
    
    //秀出全部會員
    public function showMember()
    {
        $members = Member::get();
        return view("showMember", ["members" => $members]);   
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $requesdd
     * @return \Illuminate\Http\Response
     */
    
    //新增會員(將view頁面輸入的值insert至sql裡)
    public function store(Request $request)
    {    
        $user = new Member();
        $user->account = $request->account;
        $user->password = $request->password;
        $user->name = $request->name;
        $user->user_id = $request->user_id;
        $user->phone_number = $request->phone_number;
        $user->save();
     
        //設定session裡的登入訊息
        session(["registerMsg" => "註冊成功"]);
        //重定向到這方法
        return redirect('shopCar/showShop');
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
  
    public function edit($id)
    {
        //撈出傳入的id的資料，將資料$member傳，然後秀在editMember
        $member = Member::find($id);
        return view("editMember", ["member" => $member]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //更新member table資料
    public function update(Request $request, $id)
    {   
       $member = Member::find($id);
       $member -> name = $request->name;
       $member -> account = $request->account;
       $member -> password = $request->password;
       $member -> user_id = $request->user_id;
       $member -> phone_number = $request -> phone_number;
       $member -> update(); 
       
       return redirect('shopCar/showShop');  
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //刪除會員功能
    public function destroy($id)
    {  
        $user = new Member();
        $user->destroy($id);
        return redirect('member/showMember');
    }
    
    //新增會員功能畫面
    public function addMember() 
    {
        return view('addMember');
    }
      
    //使用者登入驗證(將之設定session(),成功就導到shopCar/showShop,若是驗證失敗就)
    public function login(Request $request) 
    {        
        $account = $request -> account;
        $password = $request -> password;
      
        $isCheck = Member::where('account', $account)->where('password', $password)->exists();
        
        if($isCheck) {
            $result = Member::where('account', $account)->first();      
            session(['member' => $result]);
            
            return redirect('shopCar/showShop');
        } else {
          
            $msg ="驗證失敗，無此帳號";
            session(['msg' => $msg]);
            return redirect('member/index');            
        }
    }
    
    //註冊頁面
    public function register() 
    {
        if(session()->exists("member"))
            return redirect('shopCar/showShop');
        else
            return view('register');        
    }
    
    //用session方式寫會員修改頁面
    public function editMember() 
    {
        /*
        $id = session()->get('member')->id;
        $member = Member::find($id); 
        */
        return view('editMember', ["member" => session()->get('member')]);
    }
    
    //API檢查與登入
    
    public function checkAndLogin(Request $request) {
        
        $response = [];
        $response['status'] = 'fail';
        $response['msg'] = '';
       
        $account = $request->account;
        $password = $request->password;
        
        //檢查帳號是否註冊
        
        if(!Member::where('account', $account)->exists()) {
            $response['msg'] = "帳號未存在";
            //dd($response);
            return $response;
        }
     
        //檢查帳號密碼正確(密碼錯誤)
        if(Member::where('account', $account)->where('password', $password)->first() == null) {
            $response['msg'] = "密碼錯誤";
            
            return $response;
        }
       
        //帳號密碼都正確後，登入sesseion,轉到下一個頁面
        $result = Member::where('account', $account)->first();
        session(['member', $result]);
        
        $response['msg'] = "登入成功";  
        $response['status'] = 'success';
        
        return $response; 
        
        //$response = [];
        //$response['password'] = $request->password; 
        //return response()->json($response);
    }
}
