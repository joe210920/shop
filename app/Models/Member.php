<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function orderProduct() {
        return $this->belongTo(OrderProduct::class);
    }
}


