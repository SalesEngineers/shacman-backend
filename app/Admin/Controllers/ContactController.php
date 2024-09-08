<?php

namespace App\Admin\Controllers;

use App\Models\Contact;
use Encore\Admin\Form;
use Encore\Admin\Form\NestedForm;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Show;

class ContactController extends BaseController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Contact';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Contact());

        $grid->column('id', __('panel.id'))->sortable();
        $grid->column('name', __('panel.name'))->sortable();
        $grid->column('region', __('panel.region'));
        $grid->column('phone', __('panel.phone'));
        $grid->column('email', __('panel.email'))->default('&minus;');
        $grid->column('address', __('panel.address'))->default('&minus;');
        $grid->column('operating_mode', __('panel.operating_mode'))->view('operating-mode')->default('&minus;');
        $grid->column('is_active', __('panel.is_active'))
            //->icon([0 => 'toggle-off', 1 => 'toggle-on'], $default = '')
            ->switch([
                'on' => ['text' => 'Вкл.', 'value' => 1],
                'off' => ['text' => 'Выкл.', 'value' => 0],
            ])
            ->sortable();
        $grid->column('sort', __('panel.sort'))->sortable()->editable();

        $grid->filter(function (Filter $filter) {
            $filter->column(7, function (Filter $filter) {
                $filter->like('name', __('panel.name'));
                $filter->like('phone', __('panel.phone'));
                $filter->like('email', __('panel.email'));
                $filter->like('address', __('panel.address'));
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
        $show = new Show(Contact::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $ip = request()->ip();
        $location = \App\SypexGeo\SypexGeoFacade::get($ip);
        $region = 'Ваш регион: ' . (isset($location['region']['name_ru']) ? $location['region']['name_ru'] : 'не определен');



        $form = new Form(new Contact());

        $form->tab('Основное', function (Form $form) use ($region) {
            $form->text('name', __('panel.name'))->required();
            $form->text('region', __('panel.region'))->help($region);
            $form->text('url', __('slug'));
            $form->text('phone', __('panel.phone'))->inputmask(['mask' => '7|8 999 999-99-99'])->required();
            $form->email('email', __('panel.email'));
            $form->textarea('address', 'Основной адрес');
            $form->table('addresses', 'Другие адреса', function ($table) {
                $table->textarea('address', 'Адрес');
            });
            $form->table('operating_mode', __('panel.operating_mode'), function (NestedForm $form) {
                $form->text('name', __('panel.day'))->required();
                $form->text('value', __('panel.time'))->required();
                $form->number('sort', __('panel.sort'))->min(0)->default(0)->width('40px');
            });
            $form->switch('is_active', __('panel.is_active'))->default(true);
            $form->number('sort', __('panel.sort'))->default(10);
            $form->hidden('coords')->customFormat(function ($e) {
                return is_array($e) ? json_encode($e) : $e;
            })->default(json_encode([56.010021957014416, 92.85234643087742]));
            $form->hidden('zoom')->default(16);
            $form->html(function () {
                return '<div id="map" style="height: 450px"></div>';
            }, __('panel.map'));
        })->tab('Контент', function (Form $form) {
            $form->text('title', 'Заголовок H1');
            $form->summernote('content', __('panel.content'));
        })->tab('Изображения', function (Form $form) {
            $form->morphMany('images', '', function (Form\NestedForm $form) {
                $form->imageService('url', __('panel.image'))
                    ->sequenceName()
                    ->rules(['mimes:jpeg,jpg,png,webp']);
                $form->text('alt', __('panel.image_alt'));
                $form->text('title', __('panel.image_title'));
                $form->number('sort', __('panel.sort'))->default(10);
                $form->switch('is_active', __('panel.is_active'))->default(true);
            });
        })->tab('SEO', function (Form $form) {
            $form->text('seo.title', __('panel.title'));
            $form->text('seo.keywords', __('panel.keywords'));
            $form->textarea('seo.description', __('panel.description'))->rules('max:255');
        });

        $form->saving(function (Form $form) {
            if (is_null($form->addresses)) {
                $form->addresses = [];
            }
        });

        return $form;
    }
}
