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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('instance_id')->references('id')->on('instances');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('instance_id')->references('id')->on('instances');
            $table->foreign('step_id')->references('id')->on('steps');
            $table->foreign('sub_step_id')->references('id')->on('sub_steps');
            $table->foreign('unit_id')->references('id')->on('unit_of_measurements');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('province_id')->references('id')->on('provinces');
        });

        Schema::table('program_targets', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('instance_id')->references('id')->on('instances');
            $table->foreign('program_id')->references('id')->on('programs');
        });

        Schema::table('program_related_instances', function (Blueprint $table) {
            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('instance_id')->references('id')->on('instances');
        });

        Schema::table('program_target_files', function (Blueprint $table) {
            $table->foreign('program_target_id')->references('id')->on('program_targets');
        });

        Schema::table('program_target_provinces', function (Blueprint $table) {
            $table->foreign('program_target_id')->references('id')->on('program_targets');
            $table->foreign('province_id')->references('id')->on('provinces');
        });

        Schema::table('program_target_file_provinces', function (Blueprint $table) {
            $table->foreign('target_file_id')->references('id')->on('program_target_files');
            $table->foreign('province_id')->references('id')->on('provinces');
        });

        Schema::table('sub_steps', function (Blueprint $table) {
            $table->foreign('step_id')->references('id')->on('steps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
