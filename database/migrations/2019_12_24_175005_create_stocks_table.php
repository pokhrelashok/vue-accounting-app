<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');;

            $table->bigInteger('supplier_id')->unsigned();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');;

            $table->integer('quantity')->default(0);
            $table->decimal('cost_price', 10, 4)->delafult(0);
            $table->decimal('selling_price', 10, 4)->delafult(0);
            $table->decimal('special_price', 10, 4)->nullable();

            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('dimensions')->nullable();

            $table->date('added_at');
            $table->date('manufactured_at')->nullable();
            $table->date('expires_at')->nullable();

            $table->text('keywords')->nullable();
            $table->text('remarks')->nullable();

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
        Schema::dropIfExists('stocks');
    }
}
