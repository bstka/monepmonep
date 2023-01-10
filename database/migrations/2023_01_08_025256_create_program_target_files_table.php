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
            $table->string("description");
            $table->integer("compilation_target_count", false, true);
            $table->integer("integration_target_count", false, true);
            $table->integer("syncronization_target_count", false, true);
            $table->integer("publication_target_count", false, true);
            $table->bigInteger("program_target_id", false, true);
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
