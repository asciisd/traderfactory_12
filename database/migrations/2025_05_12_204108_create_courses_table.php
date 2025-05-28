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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_line2')->nullable();
            $table->string('slug')->nullable();
            $table->text('description');

            $table->string('video_src')->nullable();
            $table->string('video_type')->nullable();
            $table->string('video_poster')->nullable();
            $table->string('background_src')->nullable();

            $table->float('price')->nullable();
            $table->float('discount')->nullable();
            $table->float('tax')->nullable();

            $table->string('seo_title')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_image')->nullable();

            $table->boolean('active')->default(1);
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
