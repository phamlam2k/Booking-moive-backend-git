<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type_of_movie');
            $table->string('range_age');
            $table->string('dimension');
            $table->string('range_of_movie');
            $table->string('poster', '1000');
            $table->string('start_date');
            $table->string('actor');
            $table->string('director');
            $table->string('description', '2000');
            $table->string('trailer', '1000');
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
        Schema::dropIfExists('movies');
    }
}
