<?php

namespace App\Admin\Controllers;

use App\Models\Label;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LabelController extends BaseController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Лейблы';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Label());

        $grid->column('id', __('panel.id'));
        $grid->column('name', __('panel.name'));
        $grid->column('color', __('panel.color'))->view('label-color');
        $grid->column('noindex', 'Запретить индексирование')
            ->icon([0 => 'toggle-off', 1 => 'toggle-on'], $default = '')
            ->sortable();

        $grid->filter(function (Grid\Filter $filter) {
            $filter->column(7, function (Grid\Filter $filter) {
                $filter->like('name', __('panel.name'));
            });
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
        $show = new Show(Label::findOrFail($id));

        $show->field('id', __('panel.id'));
        $show->field('name', __('panel.name'));
        $show->field('color', __('panel.color'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Label());

        $form->text('name', __('panel.name'));
        $form->color('color', __('panel.color'));
        $form->switch('noindex', 'Запретить индексирование')->default(false);

        return $form;
    }
}
