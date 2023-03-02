<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductController extends Controller
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
            ->header(trans('admin.index', ['title' => "商品管理"]))
            ->description("使用於商品修改及上下架")
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
        //目前缺少一個功能：當整筆資料山除時，照片檔案不會被刪除，會留在本地硬碟中
        
        $grid = new Grid(new Product);
        $grid -> model() -> orderBy('id', 'desc'); //用id去排序 asc 是順序  desc是倒序
        //$grid -> model() -> where('stock', '>', '0'); //庫存大於0才會被篩選出來
        $grid->column('id', '產品編號') -> sortable();
        $grid->column('name', '產品名稱')->display(function($val) {
           return $val;
        });
        $grid->column('stock', '庫存')->editable();
        $grid->column('price', '單價');
        $grid->column('img_path', '照片')->image();
        $grid->created_at(trans('admin.created_at'));
        $grid->updated_at(trans('admin.updated_at'));
        //把顯示資料的功能功能拿掉
        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    
    //畫面中右邊欄位的"顯示"選項，可以跟編輯功能二選一做(客戶沒有特別要顯示功能時可以拿掉)
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->id('ID');
        $show->name('name');
        $show->created_at(trans('admin.created_at'));
        $show->updated_at(trans('admin.updated_at'));

        return $show;
    }
   
    /**
     * Make a form builder.
     *
     * @return Form
     */
    //更新跟建立的表格會建立在這邊，只需要寫一次就好，admin會自動建立
    protected function form()
    {
        $form = new Form(new Product);

        $form->text('id', '商品編號');
        $form->text('name', '商品名稱');
        $form->text('stock', '庫存');
        $form->text('price', '單價');
        //有刪除的案件出現，可以直接在畫面上刪除
        $form->image('img_path', '圖片')->removable();
        $form->display(trans('created_at'));
        $form->display(trans('updated_at'));

        return $form;
    }
}
