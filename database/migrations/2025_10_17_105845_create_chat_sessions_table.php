<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('language')->default('pt');
            $table->json('template_data')->nullable();
            $table->boolean('is_complete')->default(false);
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['session_id', 'is_complete']);
            $table->index('started_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_sessions');
    }
};
