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
        Schema::create('forum_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('slug')->unique(); // Dùng cho URL thân thiện
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable(); // Cho phép cấu trúc phân cấp
            $table->boolean('is_active')->default(true); // Có hiển thị category hay không
            $table->foreign('parent_id')->references('id')->on('forum_categories')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_categories');
    }
};
