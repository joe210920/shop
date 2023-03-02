<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
class MemberController extends Controller
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
            ->header(trans('admin.index',["title"=> "會員管理"]))
            ->description(trans('admin.description'))
            //->description('填寫頁面描述小標題')
            /* 在頁面row上新增 首頁/用戶管理/編輯用戶選項
            ->breadcrumb(
            ['text' => '首页', 'url' => '/'],
            ['text' => '用户管理', 'url' => '/member'],
            ['text' => '编辑用户']
            )
            */
            
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
        $grid = new Grid(new Member);
        //頁首
        $grid->header(function ($query) {
            return 'header';
        });
        //$grid->column('name', 'Name')->sortable();讓此選項可以直接在畫面上排序，針對單項排序
        //頁尾    
        $grid->footer(function ($query) {
            return 'footer';
        });
        
        //$grid->model()->where('id', '>', 10); 可以篩選資料
        //@TODO By 建立時間
        $grid->model()->orderBy('name', 'asc');
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->contains('name' , "姓名");
            
        });
        $grid->name('姓名')->display(function($val) {
            return $val;
        });
        $grid->account('帳號')->filter('like');
        //@TODO 密碼改為* 
        $grid->column('password', '密碼')->display(function($val){
            if(strlen($val) > 3) {
                $password  = substr($val, 0, -3) . '***';
            } else {
                $password = '***';
            }
            
            return $password;
        });
        
        $grid->phone_number('電話')->editable();
        $grid->created_at(trans('admin.created_at')); 
        $grid->updated_at(trans('admin.updated_at'));
        //將顯示功能停用
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        
        //設定頁面顯示行數
        //$grid->paginate(1);
        //此頁面禁用功能
        //$grid->disableFilter();
        //$grid->disableCreateButton();
        //$grid->disablePagination();
        //$grid->perPages([5, 10, 15, 20]);
        //$grid->column('帳號')->setAttributes(['style' => 'color:red;']);
        //$grid->column('test')->color('blue');
        //$grid->column('test')->help('這一列是....');
        //$grid->column('test2')->hide();
        //$grid->column('tags')->pluck('name')->map('ucwords')->implode('-');
        
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
        $show = new Show(Member::findOrFail($id));

        $show->id('編號');
        $show->name('姓名');
        $show->account('帳號');
        $show->password('密碼');
        $show->phone_number('電話號碼');
        $show->created_at(trans('admin.created_at'));
        $show->updated_at(trans('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    //新增資料的驗證要寫在哪裡?
    protected function form()
    {
        $form = new Form(new Member);

        $form->text('name', '姓名');
        $form->text('account', '帳號');
        $form->password('password', '密碼');
        $form->password('checkpwd', '再次輸入密碼');
        $form->text('user_id', '身分字號');
        $form->text('phone_number', '電話');
        
        $form->saved(function (Form $form) {
           admin_toastr("送審成功"); //這可以模擬alerte功能
        });

        return $form;
    }
}
