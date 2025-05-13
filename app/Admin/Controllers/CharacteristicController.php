<?php

namespace App\Admin\Controllers;

use App\Models\Characteristic;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Show;

class CharacteristicController extends BaseController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Характеристики';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Characteristic());

        $grid->column('id', __('panel.id'))->sortable();
        $grid->column('name', __('panel.name'))->sortable();
        $grid->column('is_active', __('panel.is_active'))->icon([0 => 'toggle-off', 1 => 'toggle-on'], $default = '');
        $grid->column('is_main', 'Основной на карт. товара')->icon([0 => 'toggle-off', 1 => 'toggle-on']);

        $grid->filter(function (Filter $filter) {
            $filter->column(7, function (Filter $filter) {
                $filter->like('name', __('panel.name'));
                $filter->equal('is_active', __('panel.is_active'))->select(['0' => 'Нет', '1' => 'Да']);
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
        $show = new Show(Characteristic::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Characteristic());

        $form->text('name', __('panel.name'));
        $form->switch('is_active', __('panel.is_active'))->default(true);
        $form->switch('is_main', 'Основной на карточке товара')->default(false);
        $form->number('sort', __('panel.sort'))->default(10);

        return $form;
    }
}
