<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Rules\UniqueSlugAdminForm;
use App\Services\CategoryService;
use App\Services\CharacteristicService;
use App\Services\LabelService;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends BaseController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        Admin::style('
            .product-label {
                display: inline-flex;
                align-items: center;
                white-space: nowrap;
                padding: 4px 8px;
                font-size: 12px;
                border-radius: 3px;
                border: 1px solid #f4f4f4;
                margin-bottom: 4px;
            }
            .product-label-color {
                width: 15px;
                height: 15px;
                border: 1px solid #f4f4f4;
                border-radius: 3px;
                margin-right: 8px;
            }
        ');
        $categoryService = new CategoryService();
        $labelService = new LabelService();

        $grid = new Grid(new Product());
        $grid->model()->where(['type' => $this->type])->orderBy('sort', 'desc');
        $grid->column('id', __('panel.id'));
        $grid->column('image.url', __('panel.image'))->image()->default('&minus;');
        $grid->column('name', __('panel.name'));
        $grid->column('categories', __('panel.categories'))->view('categories-as-tags');
        $grid->column('labels', __('panel.labels'))->view('labels-as-tags')->default('&minus;');
        $grid->column('sort', __('panel.sort'));
        $grid->column('created_at', __('panel.created_at'))->display(function ($time) {
            return date('d.m.Y H:i:s', strtotime($time));
        })->hide();
        $grid->column('updated_at', __('panel.updated_at'))->display(function ($time) {
            return date('d.m.Y H:i:s', strtotime($time));
        })->hide();

        $grid->filter(function (Grid\Filter $filter) use ($categoryService, $labelService) {
            $filter->column(7, function (Grid\Filter $filter) use ($categoryService, $labelService) {
                $filter->like('name', __('panel.name'));
                $filter->in('categories.category_id', __('panel.categories'))->multipleSelect($categoryService->listForSelect());
                $filter->in('labels.label_id', __('panel.labels'))->multipleSelect($labelService->listForSelect());
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
        $show = new Show(Product::where(['type' => $this->type])->findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());
        $categoryService = new CategoryService();
        $characteristicService = new CharacteristicService();
        $labelService = new LabelService();

        $form->hidden('type')->default((int)$this->type);

        Admin::headerJs(asset('js/characteristic.js'));

        $form->tab('Основное', function (Form $form) use ($categoryService, $labelService) {
            $form->text('name', __('panel.name'))->rules(['required', 'max:50']);
            $form->text('url', __('panel.slug'))->rules([
                'required',
                new UniqueSlugAdminForm(Product::class, $form)
            ]);
            $form->summernote('content', __('panel.content'));
            $form->textarea('script', 'Script')->help('Вставлять код без тега &lt;script&gt;&lt;/script&gt;');
            $form->url('video', __('panel.video'));
            $form->multipleSelect('categories', __('panel.categories'))->options($categoryService->listForSelect())->rules(['required']);
            $form->multipleSelect('labels', __('panel.labels'))->options($labelService->listForSelect());
            $form->number('sort', __('panel.sort'))->help('Чем больше число сортировки, тем выше показывается товар')->default(10);
        })->tab('Габариты', function (Form $form) use ($characteristicService) {
            $form->text('dimension.width', __('panel.width'));
            $form->text('dimension.height', __('panel.height'));
            $form->text('dimension.length', __('panel.length'));
            $form->multipleImage('dimension.images', __('panel.images'))
                ->removable();
        })->tab('Характеристики', function (Form $form) use ($characteristicService) {
            $form->hasMany('characteristics', '', function (Form\NestedForm  $form) use ($characteristicService) {
                $form->select('characteristic_id', __('panel.characteristic'))
                     ->options($characteristicService->listForSelect())
                     ->rules('required');
                $form->text('value', __('panel.value'))->rules(['required']);
            });
        })->tab('Изображения', function (Form $form) {
            $form->morphMany('images', '', function (Form\NestedForm $form) {
                $form->image('url', __('panel.image'))
                    ->name(function ($file) {
                        return \Illuminate\Support\Str::slug($file->getClientOriginalName()) . '.' . $file->guessExtension();
                    })
                     ->rules(['mimes:jpeg,jpg,png,webp']);
                $form->text('alt', __('panel.image_alt'));
                $form->text('title', __('panel.image_title'));
                $form->number('sort', __('panel.sort'))->default(10);
                $form->switch('is_active', __('panel.is_active'))->default(true);
            });
        })->tab('Файлы', function (Form $form) {
            $form->morphMany('attachments', '', function (Form\NestedForm $form) {
                $form->file('url', __('panel.file'));
                $form->text('name', __('panel.file_name'));
                $form->number('sort', __('panel.sort'))->default(10);
                $form->switch('is_active', __('panel.is_active'))->default(true);
            });
        })->tab('Преимущества', function (Form $form) {
            $form->hasMany('advantages', '', function (Form\NestedForm $form) {
                $form->text('name', __('panel.name'))->rules(['required', 'max:255']);
                $form->quill('content', __('panel.content'));
                $form->number('sort', __('panel.sort'))->default(10);
                $form->switch('is_active', __('panel.is_active'))->default(true);
                $form->divider();
                $form->image('image_url', __('panel.image'))
                     ->rules(['mimes:jpeg,jpg,png,webp']);
                $form->text('image_alt', __('panel.image_alt'));
                $form->text('image_title', __('panel.image_title'));
            });
        })->tab('SEO', function (Form $form) {
            $form->text('seo.title', __('panel.title'));
            $form->text('seo.keywords', __('panel.keywords'));
            $form->textarea('seo.description', __('panel.description'));
        });

        return $form;
    }
}
