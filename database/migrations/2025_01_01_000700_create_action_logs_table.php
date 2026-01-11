<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('action_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->constrained('users')->cascadeOnDelete();
            $table->string('action', 80);
            $table->string('target_type', 190);
            $table->unsignedBigInteger('target_id');
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['actor_id', 'action']);
            $table->index(['target_type', 'target_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('action_logs');
    }
};
