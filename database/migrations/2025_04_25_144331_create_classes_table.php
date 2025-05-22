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
        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class_code', 20);
            $table->string('class_name', 100);
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('academic_year', 20);
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('teacher_id')->references('id')->on('teachers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
