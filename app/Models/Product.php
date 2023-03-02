<?php

namespace App\Models;
use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

class Product extends BaseModel
{
  public function orderDetail() {
    return $this->belongsTo(OrderDetail::class, "product_id", "id");
  }
}
