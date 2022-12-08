<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('phone', 25)->nullable();
            $table->string('email', 25)->nullable();
            $table->text('address')->nullable();
            $table->json('social_networks')->nullable()->comment('Социальные сети');
            $table->json('operating_mode')->nullable()->comment('Режим работы');
            $table->text('requisites')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
