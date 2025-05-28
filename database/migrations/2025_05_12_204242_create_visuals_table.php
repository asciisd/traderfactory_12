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
        Schema::create('visuals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('duration');
            $table->integer('duration_seconds')->nullable();
            $table->string('video_url');
            $table->string('video_poster')->nullable();
            $table->string('video_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visuals');
    }
};
