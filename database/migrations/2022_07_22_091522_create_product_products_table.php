<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_products', function (Blueprint $table) {
            $table->unsignedBigInteger('object_id');
            $table->unsignedBigInteger('product_id');

            $table->unique(['object_id', 'product_id'], 'object_product_unique');

            $table->foreign('object_id', 'product_products_object_id_foreign')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');

            $table->foreign('product_id', 'product_products_product_id_foreign')
                  ->references('id')
                  ->on('products')
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
            $table->dropUnique('object_product_unique');
            $table->dropForeign('product_products_object_id_foreign');
            $table->dropForeign('product_products_product_id_foreign');
        });

        Schema::dropIfExists('product_products');
    }
}
