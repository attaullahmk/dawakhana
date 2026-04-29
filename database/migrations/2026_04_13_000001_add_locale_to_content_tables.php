<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['products', 'categories', 'banners', 'blog_posts', 'blog_categories'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('locale', 5)->default('en')->after('id')->index();
            });
        }
    }

    public function down(): void
    {
        $tables = ['products', 'categories', 'banners', 'blog_posts', 'blog_categories'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropColumn('locale');
            });
        }
    }
};
