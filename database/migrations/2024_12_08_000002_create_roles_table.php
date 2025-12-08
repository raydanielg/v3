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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
        });

        // Insert default roles
        \DB::table('roles')->insert([
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'System Administrator - Full access',
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'teacher',
                'display_name' => 'Teacher (Mwalimu)',
                'description' => 'Teacher - Can manage classes and exams',
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'school_manager',
                'display_name' => 'School Manager (Mkuu wa Shule)',
                'description' => 'School Manager - Can manage school operations',
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'district_manager',
                'display_name' => 'District Manager (Msimamizi wa Kiti)',
                'description' => 'District Manager - Can manage multiple schools',
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'student',
                'display_name' => 'Student (Mwanafunzi)',
                'description' => 'Student - Can take exams and view results',
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
