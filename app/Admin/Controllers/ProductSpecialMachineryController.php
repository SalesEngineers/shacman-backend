<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Encore\Admin\Form;

class ProductSpecialMachineryController extends ProductController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Спецтехника';
    /**
     * Флаг, что товар является спецтехникой
     *
     * @var bool
     */
    protected $type = Product::TYPE_SPECIAL_MACHINERY;

    protected function grid()
    {
        $grid = parent::grid();
        $grid->column('equipments', __('panel.equipments'))->view('value-as-tags')->default('&minus;');
        return $grid;
    }

    protected function form()
    {
        $form = parent::form();
        $productService = new ProductService();

        $form->tab('Навесное оборудование', function (Form $form) use ($productService) {
            $form->multipleSelect('equipments')->options($productService->equipmentsListForSelect());
        });

        return $form;
    }
}
