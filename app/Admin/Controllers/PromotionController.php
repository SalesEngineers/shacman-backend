<?php

namespace App\Admin\Controllers;

use App\Models\Promotion;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Show;

class PromotionController extends BaseController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Акции';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Promotion());

        $grid->column('id', __('panel.id'));
        $grid->column('image.url', __('panel.image'))->image();
        $grid->column('name', __('panel.name'));
        $grid->column('created_at', __('panel.created_at'))->display(function ($time) {
            return date('d.m.Y H:i:s', strtotime($time));
        })->hide();
        $grid->column('updated_at', __('panel.updated_at'))->display(function ($time) {
            return date('d.m.Y H:i:s', strtotime($time));
        })->hide();

        $grid->filter(function (Filter $filter) {
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
        $show = new Show(Promotion::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @var $id
     * @return Form
     */
    protected function form($id = null)
    {
        $form = new Form(new Promotion());

        $form->tab('Основное', function (Form $form) {
            $form->text('name', __('panel.name'))->rules(['required','max:50']);
            $form->summernote('content', __('panel.content'));
        })->tab('Изображение', function (Form $form) {
            $form->imageService('image.url', __('panel.image'))
                ->sequenceName()
                ->removable()
                ->rules(['mimes:jpeg,jpg,png,webp']);
            $form->text('image.alt', __('panel.image_alt'));
            $form->text('image.title', __('panel.image_title'));
        });

        return $form;
    }
}
