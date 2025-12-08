<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // No-op: we keep extra columns on districts to avoid sqlite index/drop issues.
        // The application logic no longer uses code/description for districts.
    }

    public function down(): void
    {
        // No-op rollback as well.
    }
};
