<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('body')->nullable();
            $table->enum('type', ['text', 'image', 'file'])->default('text');
            $table->string('file_url', 500)->nullable();
            $table->string('file_name', 255)->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            // Composite index for fetching messages in a conversation (most common query)
            $table->index(['conversation_id', 'created_at']);
            $table->index('sender_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
