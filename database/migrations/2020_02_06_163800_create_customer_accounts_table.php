<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->bigInteger('sale_id')->unsigned()->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');

            $table->bigInteger('bill_id')->unsigned()->nullable();
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');

            $table->decimal('debit', 20, 2)->default(0);
            $table->decimal('credit', 20, 2)->default(0);
            $table->decimal('balance', 20, 2)->default(0);
            $table->decimal('sale_balance', 20, 2)->default(0);
            $table->decimal('total_balance', 20, 2)->default(0);
            $table->date('added_at');
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('customer_accounts');
    }
}
