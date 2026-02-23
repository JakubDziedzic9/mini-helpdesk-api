<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('title');
            $table->text('description');

            $table->string('status')->default('open')->index(); 
            $table->string('priority')->default('medium')->index(); 

            $table->boolean('is_archived')->default(false)->index();
            $table->timestamp('archived_at')->nullable()->index();

            $table->timestamps();

            $table->index(['creator_id', 'assignee_id']);
        });
    }

    public function down(): void
    {
        // 
    }
};

