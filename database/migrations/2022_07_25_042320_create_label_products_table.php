<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_products', function (Blueprint $table) {
            $table->unsignedBigInteger('label_id');
            $table->unsignedBigInteger('product_id');

            $table->unique(['label_id', 'product_id'], 'label_product_unique');

            $table->foreign('label_id', 'label_products_label_id_foreign')
                ->references('id')
                ->on('labels')
                ->onDelete('cascade');

            $table->foreign('product_id', 'label_products_product_id_foreign')
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
        Schema::table('label_products', function(Blueprint $table) {
            $table->dropUnique('label_product_unique');
            $table->dropForeign('label_products_label_id_foreign');
            $table->dropForeign('label_products_product_id_foreign');
        });

        Schema::dropIfExists('label_products');
    }
}
