<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('railcars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('area',['yard', 'north_gate', 'south_side', 'platform_1', 'platform_2', 'platform_3']);
            $table->dateTime('arrival_date');
            $table->dateTime('due_date');
            $table->enum('status',['parked', 'loading', 'loaded', 'shipped', 'archived']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('railcars');
    }
};
