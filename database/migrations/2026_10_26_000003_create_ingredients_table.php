<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('unit')->default('kg'); // kg, gr, liter, pcs
            $table->decimal('stock_quantity', 10, 2)->default(0);
            $table->decimal('min_stock_alert', 10, 2)->default(5);
            $table->decimal('unit_cost', 12, 2)->default(0);
            $table->string('supplier')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
