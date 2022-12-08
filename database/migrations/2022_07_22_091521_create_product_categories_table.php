<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('category_id');

            $table->unique(['product_id', 'category_id'], 'product_category_unique');

            $table->foreign('product_id', 'product_categories_product_id_foreign')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('category_id', 'product_categories_category_id_foreign')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_categories', function(Blueprint $table) {
            $table->dropUnique('product_category_unique');
            $table->dropForeign('product_categories_product_id_foreign');
            $table->dropForeign('product_categories_category_id_foreign');
        });

        Schema::dropIfExists('products_categories');
    }
}
