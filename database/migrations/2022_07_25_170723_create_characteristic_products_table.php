<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacteristicProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characteristic_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('characteristic_id');
            $table->unsignedBigInteger('product_id');
            $table->string('value');

            $table->foreign('product_id', 'characteristic_products_product_id_foreign')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('characteristic_id', 'characteristic_products_characteristic_id_foreign')
                ->references('id')
                ->on('characteristics')
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
        Schema::table('characteristic_products', function(Blueprint $table) {
            $table->dropForeign('characteristic_products_product_id_foreign');
            $table->dropForeign('characteristic_products_characteristic_id_foreign');
        });

        Schema::dropIfExists('characteristics_products');
    }
}
