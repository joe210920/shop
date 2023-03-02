<?php

namespace App\Http\Middleware;


use Closure;


class ShopCarMiddle {
    
    
    
    /*
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next) {
        
        //判斷session裡是否存在member,若是沒有member就導回shopCar/index頁面(首頁)
        if(!session()->exists("member")) {
            return redirect('shopCar/index');
        }
        return $next($request);
    }    
}