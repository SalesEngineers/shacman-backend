<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dimensions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('width', 50)->nullable();
            $table->string('height', 50)->nullable();
            $table->string('length', 50)->nullable();
            $table->text('images')->nullable();

            $table->foreign('product_id', 'dimensions_product_id_foreign')
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
        Schema::table('dimensions', function(Blueprint $table) {
            $table->dropForeign('dimensions_product_id_foreign');
        });

        Schema::dropIfExists('dimensions');
    }
}
