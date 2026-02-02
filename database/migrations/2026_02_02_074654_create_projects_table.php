<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();              // UUID PK
            $table->string('title');
            $table->date('starting_date');
            $table->date('end_date')->nullable();

            $table->enum('category', ['project', 'meeting']);

            $table->uuid('created_by');                 // FK → users
            $table->timestamps();

            // Foreign key (PostgreSQL)
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
