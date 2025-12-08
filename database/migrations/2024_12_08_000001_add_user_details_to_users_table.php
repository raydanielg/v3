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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->text('address')->nullable()->after('date_of_birth');
            $table->string('school_name')->nullable()->after('address');
            $table->string('school_id')->nullable()->after('school_name');
            $table->string('role')->default('user')->after('school_id');
            $table->string('avatar_url')->nullable()->after('role');
            $table->timestamp('last_login_at')->nullable()->after('avatar_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'date_of_birth',
                'address',
                'school_name',
                'school_id',
                'role',
                'avatar_url',
                'last_login_at',
            ]);
        });
    }
};
