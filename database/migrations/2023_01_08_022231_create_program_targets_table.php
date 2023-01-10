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
        Schema::create('program_targets', function (Blueprint $table) {
            $table->id();
            $table->text("name");

            // ! Prepared these columns if needed!
            // $table->integer("compilation_target_count", false, true);
            // $table->integer("integration_target_count", false, true);
            // $table->integer("syncronization_target_count", false, true);
            // $table->integer("publication_target_count", false, true);
            // $table->string("description");
            // $table->string("verify_description");
            // $table->string("value");
            // $table->boolean("all_province");
            // ! -----------------------------------
            
            $table->smallInteger("year", false, true);
            $table->smallInteger("month", false, true);
            $table->smallInteger("day", false, true);
            $table->bigInteger("status_id", false, true);
            $table->bigInteger("instance_id", false, true)->nullable();
            $table->bigInteger("program_id", false, true);
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
        Schema::dropIfExists('program_targets');
    }
};
