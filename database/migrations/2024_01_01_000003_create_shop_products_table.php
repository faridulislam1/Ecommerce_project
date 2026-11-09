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
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained('shops')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            
            // Shop-specific overrides
            $table->decimal('custom_price', 10, 2)->nullable();
            $table->string('custom_title')->nullable();
            $table->text('custom_description')->nullable();
            $table->string('custom_thumbnail')->nullable();
            
            $table->integer('stock')->default(100);
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            // A product can be added only once per shop
            $table->unique(['shop_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_products');
    }
};

