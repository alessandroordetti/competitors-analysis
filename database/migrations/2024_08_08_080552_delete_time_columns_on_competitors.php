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
        Schema::create('competitors', function (Blueprint $table) {
            $table->id();
            $table->string('competitor');
            $table->string('sku');
            $table->string('product_title');
            $table->decimal('sale_price', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('competitors', function (Blueprint $table) {
            $table->id();
            $table->string('competitor');
            $table->string('sku');
            $table->string('product_title');
            $table->decimal('sale_price', 8, 2);
            $table->timestamps();
        });
    }
};
