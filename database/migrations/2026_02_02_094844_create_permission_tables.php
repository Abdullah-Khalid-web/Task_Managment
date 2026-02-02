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
        // ---------------------
        // Roles Table
        // ---------------------
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');       // Role name
            $table->string('guard_name'); // Usually 'web'
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        // ---------------------
        // Permissions Table
        // ---------------------
        Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');       // Permission name
            $table->string('guard_name'); // Usually 'web'
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        // ---------------------
        // Model Has Roles Pivot Table
        // ---------------------
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->uuid('role_id');       // FK to roles
            $table->uuid('model_id');      // FK to user ID
            $table->string('model_type');  // User model class

            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
            $table->primary(['role_id', 'model_id', 'model_type'], 'model_has_roles_primary');

            $table->index(['model_id', 'model_type'], 'model_has_roles_model_index');
        });

        // ---------------------
        // Model Has Permissions Pivot Table
        // ---------------------
        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->uuid('permission_id'); // FK to permissions
            $table->uuid('model_id');      // FK to user ID
            $table->string('model_type');  // User model class

            $table->foreign('permission_id')->references('id')->on('permissions')->cascadeOnDelete();
            $table->primary(['permission_id', 'model_id', 'model_type'], 'model_has_permissions_primary');

            $table->index(['model_id', 'model_type'], 'model_has_permissions_model_index');
        });

        // ---------------------
        // Role Has Permissions Pivot Table
        // ---------------------
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->uuid('permission_id'); // FK to permissions
            $table->uuid('role_id');       // FK to roles

            $table->foreign('permission_id')->references('id')->on('permissions')->cascadeOnDelete();
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
