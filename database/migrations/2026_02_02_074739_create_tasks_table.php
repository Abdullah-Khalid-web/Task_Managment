<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
          $table->uuid('id')->primary();

          $table->uuid('project_id');
          $table->uuid('parent_id')->nullable(); // sub-task

          $table->string('title');
          $table->text('description')->nullable();

          $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');

          $table->uuid('assigned_to')->nullable();
          $table->uuid('created_by');

          $table->timestamps();

          // Foreign keys (except self-reference)
          $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
          $table->foreign('assigned_to')->references('id')->on('users')->nullOnDelete();
          $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
      });

      // Add self-referencing FK in a separate statement
      Schema::table('tasks', function (Blueprint $table) {
          $table->foreign('parent_id')->references('id')->on('tasks')->nullOnDelete();
      });

    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
