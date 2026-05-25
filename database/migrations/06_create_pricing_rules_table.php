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
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('condition_key'); // e.g., 'material', 'text_length'
            $table->string('operator')->default('='); // '=', '>', '<', etc.
            $table->string('condition_value'); // e.g., 'wood', '20'
            $table->decimal('price_adjustment', 8, 2);
            $table->string('type')->default('fixed'); // 'fixed' or 'percentage'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};
