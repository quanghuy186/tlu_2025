<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('code', 20);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('description')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 200)->nullable();
            $table->text('address')->nullable();
            $table->integer('level');
            $table->string('department_type', 200)->nullable();
            $table->foreign('parent_id')->references('id')->on('departments');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
