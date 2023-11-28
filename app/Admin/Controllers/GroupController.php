<?php

namespace App\Admin\Controllers;

use App\Models\Group;
use App\Services\CharacteristicService;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Grid\Filter;

class GroupController extends BaseController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Группы характеристик';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Group());

        $grid->column('id', __('panel.id'))->sortable();
        $grid->column('name', __('panel.name'))->sortable();
        $grid->column('characteristics', __('panel.characteristics'))->view('value-as-tags')->default('&minus;');

        $grid->filter(function (Filter $filter) {
            $filter->disableIdFilter();

            $filter->column(7, function (Filter $filter) {
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
        $show = new Show(Group::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Group());
        $characteristicService = new CharacteristicService();

        $form->text('name', __('panel.name'))->rules(['required']);

        $form->multipleSelect('characteristics', __('panel.characteristics'))->options($characteristicService->listForSelect())->rules(['required']);

        return $form;
    }
}
