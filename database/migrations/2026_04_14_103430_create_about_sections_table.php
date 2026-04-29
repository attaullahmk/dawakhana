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
        Schema::create('about_sections', function (Blueprint $バランス) {
            $バランス->id();
            $バランス->string('locale')->default('en');
            
            // Hero Section
            $バランス->string('hero_title')->nullable();
            $バランス->string('hero_subtitle')->nullable();
            $バランス->string('hero_image')->nullable();
            
            // Vision Section
            $バランス->string('vision_title')->nullable();
            $バランス->string('vision_heading')->nullable();
            $バランス->text('vision_description_1')->nullable();
            $バランス->text('vision_description_2')->nullable();
            $バランス->string('vision_image')->nullable();
            
            // Founder Section
            $バランス->string('founder_name')->nullable();
            $バランス->string('founder_title')->nullable();
            $バランス->string('founder_image')->nullable();
            
            // Stats Section
            $バランス->json('stats')->nullable(); // [{"number": "15+", "label": "Years Experience", "desc": "..."}]

            $バランス->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
