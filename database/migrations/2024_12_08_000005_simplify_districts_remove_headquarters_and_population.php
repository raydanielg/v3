<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('districts', function (Blueprint $table) {
            if (Schema::hasColumn('districts', 'headquarters')) {
                $table->dropColumn('headquarters');
            }
            if (Schema::hasColumn('districts', 'population')) {
                $table->dropColumn('population');
            }
        });
    }

    public function down(): void
    {
        Schema::table('districts', function (Blueprint $table) {
            if (! Schema::hasColumn('districts', 'headquarters')) {
                $table->string('headquarters')->nullable()->after('description');
            }
            if (! Schema::hasColumn('districts', 'population')) {
                $table->integer('population')->nullable()->after('headquarters');
            }
        });
    }
};
