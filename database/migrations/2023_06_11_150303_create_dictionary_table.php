<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionary', function (Blueprint $table) {
            $table->id();
            $table->string('word', 100);
            $table->string('traduction', 1000)->nullable();
            $table->string('type', 1000)->default('');
            $table->text('definitions');
            $table->dateTime('date_create');
            $table->dateTime('date_learned')->nullable();
            $table->dateTime('date_revision')->nullable();
            $table->boolean('learned')->nullable();
            $table->boolean('important')->nullable();
            $table->integer('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionary');
    }
}
