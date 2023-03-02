<?php

namespace App\Models;
use App\Models\BaseModel;

//product_details
class OrderDetail extends BaseModel
{
    //一對一 
     public function product() {
        // 將Product table的key id作為外鍵然後 然後將參考到本地order_detail table的欄位product_id
        return $this->hasOne(Product::class, "id","product_id");
     }
}
