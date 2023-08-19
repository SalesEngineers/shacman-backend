<?php

namespace App\Admin\Controllers;

use App\Models\Gallery;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GalleryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Gallery';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Gallery());

        $grid->column('name', __('panel.name'))->sortable();

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
        $show = new Show(Gallery::findOrFail($id));

        $show->field(__('panel.name'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Gallery());

        $form->text('name', __('panel.name'))->rules(['required', 'max:50']);

        $form->divider('Изображения');

        $form->morphMany('images', '', function (Form\NestedForm $form) {
            $form->imageService('url', __('panel.image'))
                ->sequenceName()
                ->rules(['mimes:jpeg,jpg,png,webp']);
            $form->text('alt', __('panel.image_alt'));
            $form->text('title', __('panel.image_title'));
            $form->number('sort', __('panel.sort'))->default(10);
            $form->switch('is_active', __('panel.is_active'))->default(true);
        });

        return $form;
    }
}
