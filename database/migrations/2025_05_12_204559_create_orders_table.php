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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('transaction_id')->nullable();
            $table->string('status')->nullable();
            $table->double('conversion_rate')->nullable();
            $table->double('vendor_fees')->nullable();
            $table->string('currency')->nullable();
            $table->string('method')->nullable();
            $table->string('provider')->nullable();
            $table->json('payment_response')->nullable();
            $table->double('total')->nullable();
            $table->double('sub_total')->nullable();
            $table->numericMorphs('orderable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
