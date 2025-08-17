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
        if(!Schema::hasTable('stock_transfers')) {
            Schema::create('stock_transfers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('inventory_item_id')->constrained('inventory_items');
                $table->foreignId('from_warehouse_id')->constrained('warehouses');
                $table->foreignId('to_warehouse_id')->constrained('warehouses');
                $table->unsignedBigInteger('quantity');
                $table->timestamp('transfer_date');
                $table->foreignId('user_id')->nullable()->constrained('users');
                $table->timestamps();
                $table->index(['from_warehouse_id']);
                $table->index(['to_warehouse_id']);
                $table->index(['inventory_item_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfers');
    }
};
