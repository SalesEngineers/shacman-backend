<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacteristicCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characteristic_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('characteristic_id');
            $table->unsignedBigInteger('category_id');

            $table->unique(['characteristic_id', 'category_id'], 'characteristic_category_unique');

            $table->foreign('category_id', 'characteristic_categories_category_id_foreign')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');

            $table->foreign('characteristic_id', 'characteristic_categories_characteristic_id_foreign')
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
        Schema::table('characteristic_categories', function(Blueprint $table) {
            $table->dropUnique('characteristic_category_unique');
            $table->dropForeign('characteristic_categories_category_id_foreign');
            $table->dropForeign('characteristic_categories_characteristic_id_foreign');
        });

        Schema::dropIfExists('characteristic_categories');
    }
}
