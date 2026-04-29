<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop unique on key first
        Schema::table('settings', function (Blueprint $table) {
            $table->dropUnique(['key']);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('locale', 5)->default('en')->after('key');
            $table->unique(['key', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropUnique(['key', 'locale']);
            $table->dropColumn('locale');
            $table->unique('key');
        });
    }
};
