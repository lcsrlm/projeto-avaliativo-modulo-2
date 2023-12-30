<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_birth')->nullable();
            $table->string('cpf', 14)->unique();
            $table->foreignId('plan_id')->constrained('plans');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('date_birth');
            $table->dropColumn('cpf');
            $table->dropForeign(['plan_id']);
            $table->dropColumn('plan_id');
        });
    }
};
