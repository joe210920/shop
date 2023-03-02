<?php

namespace App\Http\Middleware;

use Closure;

class MemberMiddle {
    
    public function handle($request, Closure $next) {
        //判斷session裡是否存在member,若是沒有member就導回shopCar/index頁面(首頁)
        if(!session()->exists("member")) {
            return redirect('member/index');
        }
        
        return $next($request);
    }
}