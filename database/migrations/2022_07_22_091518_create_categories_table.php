<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pid')->nullable();
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->string('name', 100);
            $table->string('url');
            $table->text('content')->nullable();
            $table->boolean('is_tag')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort')->default(10);
            $table->timestamps();

            $table->foreign('pid', 'categories_pid_foreign')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');

            $table->foreign('promotion_id', 'categories_promotion_id_foreign')
                  ->references('id')
                  ->on('promotions')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function(Blueprint $table) {
            $table->dropForeign('categories_pid_foreign');
            $table->dropForeign('categories_promotion_id_foreign');
        });

        Schema::dropIfExists('categories');
    }
}
