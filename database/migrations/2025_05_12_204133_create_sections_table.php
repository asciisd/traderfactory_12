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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('title');
            $table->string('name')->nullable();
            $table->text('description');
            $table->text('overview');
            $table->string('slug')->nullable();
            $table->string('video_src')->nullable();
            $table->string('video_type')->nullable();
            $table->string('video_poster')->nullable();
            $table->string('background_src')->nullable();
            $table->string('color')->nullable();
            $table->string('duration')->nullable();
            $table->string('image_alt')->nullable();

            $table->string('seo_title')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
