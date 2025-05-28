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
        Schema::create('glossaries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->fulltext();
            $table->string('title_ar')->fulltext();
            $table->string('slug')->unique();
            $table->string('initials')->nullable();
            $table->string('initials_ar');
            $table->text('body')->nullable()->fulltext();
            $table->text('body_ar')->fulltext();
            $table->string('topic')->nullable()->fulltext();
            $table->string('topic_ar')->nullable()->fulltext();
            $table->string('category')->nullable()->fulltext();
            $table->string('category_ar')->fulltext();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glossaries');
    }
};
