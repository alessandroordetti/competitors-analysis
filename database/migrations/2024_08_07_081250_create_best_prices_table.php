<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBestPricesTable extends Migration
{
    public function up()
    {
        Schema::create('best_prices', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('product_title');
            $table->decimal('sale_price', 8, 2);
            $table->string('winner_competitor');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('best_prices');
    }
}
