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
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('content');
            $table->text('images')->nullable();
            $table->string('status', 20)->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('reject_reason')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->integer('view_count')->default(0);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->timestamp('last_comment_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->nullable()->references('id')->on('forum_categories');
            $table->foreign('approved_by')->references('id')->on('users');

            $table->timestamps();
        });
    }
    // approved_by INTEGER REFERENCES users(user_id), -- Người duyệt bài
    // approved_at TIMESTAMP, -- Thời điểm duyệt
    // reject_reason TEXT, -- Lý do từ chối nếu có

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_posts');
    }
};
