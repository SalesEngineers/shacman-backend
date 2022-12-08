<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryTree;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Tree;
use Encore\Admin\Form;

class CategoryTreeController extends Controller
{
    use HasResourceActions;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header(__('panel.category_sort'));
            $content->body($this->treeView());
        });
    }

    protected function treeView()
    {
        $tree = new Tree(new CategoryTree());

        $tree->disableCreate();

        $tree->tools(function (Tree\Tools $tools) {
            $tools->add(
                sprintf(
                    '<a href="%s" class="btn btn-sm btn-success"><i class="fa fa-list-ul"></i><span>&nbsp;%s</span></a>',
                    route('.categories.index'),
                    'Список категорий'
                )
            );
        });


        $tree->branch(function ($branch) {
            $payload = "<strong>{$branch['name']}</strong>";
            return $payload;
        });

        return $tree;
    }

    public function form()
    {
        return new Form(new CategoryTree());
    }

    public function edit($id)
    {
        return redirect(route('.categories.edit', ['category' => $id]));
    }
}
