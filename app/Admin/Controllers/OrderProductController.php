<?php

namespace App\Admin\Controllers;

use App\Models\OrderProduct;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table; //引用table套件才能work(彈出視窗)
use App\Admin\Actions\Post\Replicate;

class OrderProductController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header(trans('admin.index', ['title'=>'訂單管理']))
            ->description('查看與修改訂單功能')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header(trans('admin.detail'))
            ->description(trans('admin.description'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header(trans('admin.edit'))
            ->description(trans('admin.description'))
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header(trans('admin.create'))
            ->description(trans('admin.description'))
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OrderProduct);

        $grid->column('id', '訂單編號')->sortable();
        $grid->column('member.name', '客戶名稱')->filter;
        $grid->column('total', '總金額')->editable();
        $grid->column('購買明細')->display(function($val){
            return "開啟";
        })->modal(function($model){
           
            $datas =[];
            
            $details = $model->details()->get();
            
            foreach ($details as $detail) {
                $datas[] =[
                    $detail->product->name,
                    $detail->qty,
                    $detail->total,
                ];
            }
            
            return new Table(['商品', '數量', '總金額'], $datas);
        });
        $grid->created_at(trans('admin.created_at'));
        $grid->updated_at(trans('admin.updated_at'));
        $grid->disableCreateButton();
        $grid->actions(function ($actions){
            //禁用刪除功能
            $actions->disableDelete();
            //禁用編輯功能
            $actions->disableEdit();
            //禁用顯示功能
            //$actions->disableView();
             
            $actions->add(new Replicate);
        });
               
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(OrderProduct::findOrFail($id));

        $show->id('訂單編號');
        $show->field('member.name', '客戶編號');
        $show->total('總價錢');
        $show->created_at(trans('admin.created_at'));
        $show->updated_at(trans('admin.updated_at'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new OrderProduct);
        $form->text('id', '編號');
        $form->text('member.name', '客戶編號');
        $form->text('total', '總價錢');
        $form->display(trans('created_at'));
        $form->display(trans('updated_at'));

        return $form;
    }
}
