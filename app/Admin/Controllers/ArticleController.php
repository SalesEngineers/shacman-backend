<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Rules\UniqueSlugAdminForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Show;

class ArticleController extends BaseController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Статьи';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        $grid->column('id', __('panel.id'))->sortable();
        $grid->column('imageVertical.url', __('panel.image_vertical'))->image()->default('&minus;');
        $grid->column('imageHorizontal.url', __('panel.image_horizontal'))->image()->default('&minus;');
        $grid->column('name', __('panel.name'))->sortable();
        $grid->column('url', __('panel.slug'));
        $grid->column('is_main', __('panel.is_main'))->icon([0 => 'toggle-off', 1 => 'toggle-on'], $default = '')->sortable();
        $grid->column('sort', __('panel.sort'))->sortable();
        $grid->column('published_at', __('panel.published_at'))->sortable();

        $grid->filter(function (Filter $filter) {
            $filter->column(7, function (Filter $filter) {
                $filter->like('name', __('panel.name'));
                $filter->equal('is_main', __('panel.is_main'))->select(['0' => 'Нет', '1' => 'Да']);
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
        $show = new Show(Article::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article());

        $form->tab('Основное', function (Form $form) {
            $form->text('name', __('panel.name'))->rules(['required']);
            $form->text('url', __('panel.slug'))->rules([
                'required',
                new UniqueSlugAdminForm(Article::class, $form)
            ]);
            $form->summernote('content', __('panel.content'))->rules(['required']);
            $form->switch('is_main', __('panel.is_main'));
            $form->datetime('published_at', __('panel.published_at'))->default(date('Y-m-d H:i:s'));
            $form->number('sort', __('panel.sort'))->default(10);
            $form->url('video', __('panel.video'));
        })->tab('Изображения', function (Form $form) {
            $form->image('imageVertical.url', __('panel.image_vertical'))
                ->name(function ($file) {
                    return \Illuminate\Support\Str::slug($file->getClientOriginalName()) . '.' . $file->guessExtension();
                })
                 ->rules(['mimes:jpeg,jpg,png,webp'])
                 ->removable();
            $form->text('imageVertical.alt', __('panel.image_alt'));
            $form->text('imageVertical.title', __('panel.image_title'));
            $form->hidden('imageVertical.is_vertical')->default(1);
            $form->divider();
            $form->image('imageHorizontal.url', __('panel.image_horizontal'))
                ->name(function ($file) {
                    return \Illuminate\Support\Str::slug($file->getClientOriginalName()) . '.' . $file->guessExtension();
                })
                 ->rules(['mimes:jpeg,jpg,png,webp'])
                 ->removable();
            $form->text('imageHorizontal.alt', __('panel.image_alt'));
            $form->text('imageHorizontal.title', __('panel.image_title'));
            $form->hidden('imageHorizontal.is_horizontal')->default(1);
        })->tab('SEO', function (Form $form) {
            $form->text('seo.title', __('panel.title'));
            $form->text('seo.keywords', __('panel.keywords'));
            $form->textarea('seo.description', __('panel.description'));
        });

        return $form;
    }
}
