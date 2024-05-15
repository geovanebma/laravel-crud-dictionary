<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhrasalVerbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('phrasal_verbs', function (Blueprint $table) {
            $table->id();
            $table->string('word', 100);
            $table->text('traduction');
            $table->text('derivatives');
            $table->text('examples');
            $table->text('synonyms');
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
        Schema::dropIfExists('phrasal_verbs');
    }
}
