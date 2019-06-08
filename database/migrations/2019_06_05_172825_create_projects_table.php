<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('officer_id');
            $table->integer('readiness_id');
            $table->integer('readiness_type_id');
            $table->string('amount')->default(0);
            $table->string('title');
            $table->string('reference');
            $table->string('end_date')->nullable();
            $table->string('start_date')->nullable();
            $table->string('status')->default('under implementation');
        });

        Schema::create('country_project', function (Blueprint $table) {
            $table->integer('country_id');
            $table->integer('project_id');
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::create('officers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::create('readiness', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('readiness');
        });

        Schema::create('readiness_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
        });

        Schema::create('disbursements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id');
            $table->string('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('country_project');
        Schema::dropIfExists('officers');
        Schema::dropIfExists('readiness');
        Schema::dropIfExists('readiness_types');
        Schema::dropIfExists('disbursements');
    }
}
