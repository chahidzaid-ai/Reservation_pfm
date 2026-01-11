<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('resource_categories')->cascadeOnDelete();
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name', 190);
            $table->string('location', 190)->nullable();
            $table->string('state', 20)->default('available'); // available|maintenance|disabled
            $table->json('specs')->nullable(); // CPU/RAM/OS/etc
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['category_id', 'state']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
