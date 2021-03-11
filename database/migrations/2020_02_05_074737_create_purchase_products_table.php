<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('purchase_products', function (Blueprint $table) {

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('purchase_id')->unsigned();
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');;

            $table->bigInteger('stock_id')->unsigned();
            $table->foreign('stock_id')->references('id')->on('stocks');

            $table->longText('metadata')->nullable();

            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_products');
    }
}
