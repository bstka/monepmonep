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
        Schema::create('program_quantitatives', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('program_id', false, true);
            $table->bigInteger('unit_id', false, true);
            $table->bigInteger('quantitative', false, true);
            $table->smallInteger('year', false, true);
            $table->text('description')->default('-');
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
        Schema::dropIfExists('program_quantitatives');
    }
};
