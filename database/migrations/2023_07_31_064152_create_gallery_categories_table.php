<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('gallery_id');
            $table->unsignedBigInteger('category_id');

            $table->unique(['gallery_id', 'category_id'], 'gallery_category_unique');

            $table->foreign('gallery_id', 'gallery_categories_gallery_id_foreign')
                ->references('id')
                ->on('galleries')
                ->onDelete('cascade');

            $table->foreign('category_id', 'gallery_categories_category_id_foreign')
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
        Schema::table('gallery_categories', function(Blueprint $table) {
            $table->dropUnique('gallery_category_unique');
            $table->dropForeign('gallery_categories_gallery_id_foreign');
            $table->dropForeign('gallery_categories_category_id_foreign');
        });

        Schema::dropIfExists('gallery_categories');
    }
}
