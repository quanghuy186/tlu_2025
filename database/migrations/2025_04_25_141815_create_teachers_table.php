<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('teacher_code', 20)->nullable();
            $table->string('academic_rank', 50)->nullable();
            $table->string('specialization', 100)->nullable();
            $table->string('position', 100)->nullable();
            $table->string('office_location', 100)->nullable();
            $table->text('office_hours')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('department_id')->references('id')->on('departments');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
