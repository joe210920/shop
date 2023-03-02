<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
//@TODO 自行修改刪除
class Replicate extends RowAction
{
    public $name = '刪除';
   
    public function handle(Model $model)
    {
       foreach ($model->details() as  $detail){
           $product =  $detail->product();
           $product-> stock += $detail-> qty;
           $product->save();
       }
        
       $model->delete();
        //return $this->response()->success('刪除成功!')->refresh();
    }

}