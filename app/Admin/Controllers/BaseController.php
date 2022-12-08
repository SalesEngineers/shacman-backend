<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\DropdownActions;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

abstract class BaseController extends AdminController
{
    public static $hideActions = [
        'view' => true,
        'delete' => false,
        'edit' => false,
        'export' => true
    ];

    public function index(Content $content)
    {
        /**
         * @var Grid $grid
         */
        $grid = $this->grid();

        $hideActions = static::$hideActions;
        $grid->actions(function (DropdownActions $actions) use ($hideActions) {
                $actions->disableView($hideActions['view'] ?? false);
                $actions->disableEdit($hideActions['edit'] ?? false);
                $actions->disableDelete($hideActions['delete'] ?? false);
             });
        $grid->disableExport($hideActions['export'] ?? false);

        return $content
            ->title($this->title())
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($grid);
    }

    public function show($id, Content $content)
    {
        /**
         * @var Show $detail;
         */
        $show = $this->detail($id);

        return $content
            ->title($this->title())
            ->description($this->description['show'] ?? trans('admin.show'))
            ->body($show);
    }

    public function edit($id, Content $content)
    {
        $hideActions = static::$hideActions;

        /**
         * @var Form $form
         */
        $form = $this->form($id);
        $form->header()
             ->disableView($hideActions['view'] ?? false)
             ->disableDelete($hideActions['delete'] ?? false);
        $form->footer()
             ->disableViewCheck($hideActions['view'] ?? false)
             ->disableReset();

        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($form->edit($id));
    }

    public function create(Content $content)
    {
        $hideActions = static::$hideActions;

        /**
         * @var Form $form
         */
        $form = $this->form();
        $form->header()
             ->disableView($hideActions['view'] ?? false)
             ->disableDelete($hideActions['delete'] ?? false);
        $form->footer()
             ->disableViewCheck($hideActions['view'] ?? false)
             ->disableReset();

        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($form);
    }
}
