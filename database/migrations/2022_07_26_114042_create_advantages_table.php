<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvantagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advantages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->text('content')->nullable();
            $table->integer('sort')->default(10);
            $table->boolean('is_active')->default(true);
            $table->string('image_url')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_title')->nullable();
            $table->timestamps();

            $table->foreign('product_id', 'advantages_product_id_foreign')
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
            $table->dropForeign('advantages_product_id_foreign');
        });

        Schema::dropIfExists('advantages');
    }
}
