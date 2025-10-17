<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->enum('type', ['user', 'bot', 'system']);
            $table->text('message');
            $table->string('language')->default('pt');
            $table->json('metadata')->nullable();
            $table->timestamp('sent_at');
            $table->timestamps();

            $table->foreign('session_id')->references('session_id')->on('chat_sessions')->onDelete('cascade');
            $table->index(['session_id', 'type']);
            $table->index('sent_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
