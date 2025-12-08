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
        Schema::table('regions', function (Blueprint $table) {
            if (Schema::hasColumn('regions', 'capital')) {
                $table->dropColumn('capital');
            }
            if (Schema::hasColumn('regions', 'population')) {
                $table->dropColumn('population');
            }
        });

        Schema::table('districts', function (Blueprint $table) {
            if (Schema::hasColumn('districts', 'population')) {
                $table->dropColumn('population');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            if (! Schema::hasColumn('regions', 'capital')) {
                $table->string('capital')->nullable()->after('description');
            }
            if (! Schema::hasColumn('regions', 'population')) {
                $table->integer('population')->nullable()->after('capital');
            }
        });

        Schema::table('districts', function (Blueprint $table) {
            if (! Schema::hasColumn('districts', 'population')) {
                $table->integer('population')->nullable()->after('description');
            }
        });
    }
};
