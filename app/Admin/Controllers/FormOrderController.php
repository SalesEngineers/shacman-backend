<?php

namespace App\Admin\Controllers;

use App\Models\FormOrder;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class FormOrderController extends BaseController
{
    protected $title = 'Заявки';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FormOrder());
        $grid->disableCreateButton()->disableFilter();
        $grid->disableActions();
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('panel.id'))->sortable();
        $grid->column('subject', __('panel.subject'));
        $grid->column('fields', __('panel.fields'))->view('form-order-fields');
        $grid->column('page', __('panel.page'))->default('&minus;');
        $grid->column('attachment.url', __('panel.attachment'))->downloadable()->default('&minus;');
        $grid->column('created_at', __('panel.created_at'))->display(function ($date) {
            return date('d.m.Y H:i:s', strtotime($date));
        });

        return $grid;
    }

    public function edit($id, Content $content)
    {
        return redirect()->route('admin.form-orders.index');
    }

    public function show($id, Content $content)
    {
        return redirect()->route('admin.form-orders.index');
    }

    public function form()
    {
        return new Form(new FormOrder());
    }
}
