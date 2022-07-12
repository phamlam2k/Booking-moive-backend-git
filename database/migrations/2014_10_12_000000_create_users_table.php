<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('gender')->nullable();
            $table->string('birth')->nullable();
            $table->string('number_phone')->nullable();
            $table->boolean('role');
            $table->string('address')->nullable();
            $table->string('email')->unique()->default(NULL);
            $table->boolean('confirm');
            $table->string('confirmation_code')->default(NULL);
            $table->dateTime('confirmation_code_expired_in')->default(NULL);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
