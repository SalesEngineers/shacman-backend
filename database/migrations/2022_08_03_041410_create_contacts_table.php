<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('phone', 25)->nullable();
            $table->string('email', 25)->nullable();
            $table->text('address')->nullable();
            $table->json('operating_mode')->nullable()->comment('Режим работы');
            $table->string('coords')->nullable();
            $table->unsignedTinyInteger('zoom')->default(16);
            $table->boolean('is_active')->default(true);
            $table->integer('sort')->default(10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
