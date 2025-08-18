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
        if(!Schema::hasTable('stocks')) {
            Schema::create('stocks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnDelete()->cascadeOnUpdate();
                $table->unsignedBigInteger('quantity')->default(0);
                $table->integer('min_stock_level')->default(0);
                $table->boolean('is_notified_low_stock')->default(false);
                $table->timestamps();
                $table->unique(['warehouse_id', 'inventory_item_id']);
                $table->index(['warehouse_id']);
                $table->index(['inventory_item_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
