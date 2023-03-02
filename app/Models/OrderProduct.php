<?php

namespace App\Models;
use App\Models\BaseModel;


//一張訂單 會有一個購買者/多筆訂單明細 / 一筆明細對應一個商品
//一對多 order_products 對應 users與order_details(對應兩個TABLE)/
//(一對一  order_details table 裡的product_id 對應 products 的id

class OrderProduct extends BaseModel
{
    // Product::class 等於 App\Models\OrderDetail
    
    //一對多
    public function details() {
        return $this->hasMany(OrderDetail::class, "order_product_id");
    }
    //一對一
    public function member() {
        return  $this->hasOne(Member::class, 'id', 'member_id');
    }
}
      