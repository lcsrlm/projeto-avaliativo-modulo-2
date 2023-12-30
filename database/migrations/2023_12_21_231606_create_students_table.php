<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->date('date_birth');
            $table->string('cpf')->unique();
            $table->string('contact');
            $table->foreignId('user_id')->constrained();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('number')->nullable();
            $table->string('street')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('cep')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
