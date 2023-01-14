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
        Schema::create('program_target_files', function (Blueprint $table) {
            $table->id();
            $table->text("compilation_doc")->nullable();
            $table->text("integration_doc")->nullable();
            $table->string("description")->nullable();
            $table->integer("compilation_target_count", false, true)->nullable();
            $table->integer("integration_target_count", false, true)->nullable();
            $table->integer("syncronization_target_count", false, true)->nullable();
            $table->integer("publication_target_count", false, true)->nullable();
            $table->integer("compilation_value", false, true)->nullable();
            $table->integer("integration_value", false, true)->nullable();
            $table->integer("syncronization_value", false, true)->nullable();
            $table->integer("publication_value", false, true)->nullable();
            $table->bigInteger("program_target_id", false, true)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('program_target_files');
    }
};
