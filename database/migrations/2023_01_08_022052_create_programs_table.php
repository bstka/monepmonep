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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->text("name");
            $table->text("event");
            $table->text("output");
            $table->string("code");
            $table->text("value");
            $table->bigInteger("unit_id", false, true);
            $table->bigInteger("status_id", false, true);
            $table->bigInteger("instance_id", false, true);
            $table->bigInteger("step_id", false, true);
            $table->bigInteger("sub_step_id", false, true);
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
        Schema::dropIfExists('programs');
    }
};
