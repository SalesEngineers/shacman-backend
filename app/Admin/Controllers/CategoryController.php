<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Rules\UniqueSlugAdminForm;
use App\Services\CategoryService;
use App\Services\CharacteristicService;
use App\Services\GalleryService;
use App\Services\PromotionService;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Show;

class CategoryController extends BaseController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Категории';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());
        $categoryService = new CategoryService();
        $promotionService = new PromotionService();

        $grid->column('id', __('panel.id'))->sortable();
        $grid->column('image.url', __('panel.image'))->image()->default('&minus;');
        $grid->column('name', __('panel.name'))->sortable();
        $grid->column('url', __('panel.slug'));
        $grid->column('parent', __('panel.pid'))->view('parent-category')->default('&minus;');
        $grid->column('promotion.name', __('panel.promotion'))->default('&minus;');
        $grid->column('filters', __('panel.filters'))->view('value-as-tags')->default('&minus;');
        $grid->column('characteristics', __('panel.characteristics'))->view('value-as-tags')->default('&minus;');
        $grid->column('is_tag', __('panel.is_tag'))->icon([0 => 'toggle-off', 1 => 'toggle-on'], $default = '')->sortable();
        $grid->column('is_active', __('panel.is_active'))->icon([0 => 'toggle-off', 1 => 'toggle-on'], $default = '')->sortable();

        $grid->filter(function (Filter $filter) use ($categoryService, $promotionService) {
            $filter->disableIdFilter();

            $filter->column(7, function (Filter $filter) use ($categoryService, $promotionService) {
                $filter->like('name', __('panel.name'));
                $filter->like('content', __('panel.content'));
                $filter->equal('is_active', __('panel.is_active'))->select(['0' => 'Нет', '1' => 'Да']);
                $filter->equal('is_tag', __('panel.is_tag'))->select(['0' => 'Нет', '1' => 'Да']);
                $filter->in('pid', __('panel.pid'))->multipleSelect($categoryService->listForSelect());
                $filter->in('promotion_id', __('panel.promotion'))->multipleSelect($promotionService->listForSelect());
            });

        });

        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(
                sprintf(
                    '<a href="%s" class="btn btn-sm btn-success"><i class="fa fa-list-ul"></i><span>&nbsp;&nbsp;%s</span></a>',
                    route('.category-trees.index'),
                    __('panel.sort')
                )
            );
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
        $show = new Show(Category::findOrFail($id));
        $show->field(__('panel.id'));
        $show->field(__('panel.name'));
        $show->field(__('panel.image'))->image();

        return $show;
    }

    /**
     * @param null $id
     *
     * @return Form
     */
    protected function form($id = null)
    {
        $form = new Form(new Category());
        $categoryService = new CategoryService();
        $promotionService = new PromotionService();
        $characteristicService = new CharacteristicService();
        $galleryService = new GalleryService;

        $form->tab('Основное', function (Form $form) use ($categoryService, $promotionService, $id) {
            $form->text('name', __('panel.name'))->rules(['required','max:50']);
            $form->text('url', __('panel.slug'))
                 ->rules([
                     'required',
                     new UniqueSlugAdminForm(Category::class, $form)
                 ]);
            $form->summernote('content', __('panel.content'));
            $form->select('pid', __('panel.pid'))->options($categoryService->listForSelect($id));
            $form->select('promotion_id', __('panel.promotion'))->options($promotionService->listForSelect());
            $form->switch('is_tag', __('panel.is_tag'));
            $form->switch('is_active', __('panel.is_active'))->default(true);
            $form->url('video', __('panel.video'));

            $form->table('videos', __('panel.video'), function ($table) {
                $table->url('video', 'Ссылки (YouTube)');
            });
        })->tab('Изображение', function (Form $form) {
            $form->imageService('image.url', __('panel.image'))
                ->sequenceName()
                ->removable()
                ->rules(['mimes:jpeg,jpg,png,webp']);
            $form->text('image.alt', __('panel.image_alt'));
            $form->text('image.title', __('panel.image_title'));
        })->tab('Фильтр товаров', function (Form $form) use ($characteristicService) {
            $form->multipleSelect('filters', __('panel.filters'))
                ->options($characteristicService->listForSelect());
        })->tab('Главные характеристики товаров', function (Form $form) use ($characteristicService) {
            $form->multipleSelect('characteristics', __('panel.characteristics'))
                 ->options($characteristicService->listForSelect());
        })->tab('SEO', function (Form $form) {
            $form->text('seo.title', __('panel.title'));
            $form->text('seo.keywords', __('panel.keywords'));
            $form->textarea('seo.description', __('panel.description'));
        })->tab('Галерея', function (Form $form) use ($galleryService) {
            $form->text('gallery_name', __('panel.name'))->rules(['max:50']);
            $form->multipleSelect('gallery', __('panel.gallery'))->options($galleryService->listForSelect());
        });

        $form->saving(function (Form $form) {
            if (is_null($form->videos)) {
                $form->videos = [];
            }
        });

        return $form;
    }
}
