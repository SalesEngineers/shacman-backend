<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Form;

class ProductAttachedEquipmentController extends ProductController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Навесное оборудование';
    /**
     * Флаг, что товар является навесным оборудованием
     *
     * @var bool
     */
    protected $type = Product::TYPE_ATTACHED_EQUIPMENT;


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return parent::form();
    }
}
