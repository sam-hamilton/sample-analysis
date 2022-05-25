<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('test_id');
            $table->string('test_strip');
            $table->string('result')->nullable();
            $table->boolean('analysis_failed')->nullable();
            $table->string('reading_one_name')->nullable();
            $table->decimal('reading_one_value')->nullable();
            $table->string('reading_two_name')->nullable();
            $table->decimal('reading_two_value')->nullable();
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
        Schema::dropIfExists('samples');
    }
}
