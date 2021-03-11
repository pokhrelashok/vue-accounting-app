<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');

            $table->bigInteger('purchase_id')->unsigned()->nullable();
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');

            $table->bigInteger('bill_id')->unsigned()->nullable();
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');

            $table->decimal('debit', 20, 2)->default(0);
            $table->decimal('credit', 20, 2)->default(0);
            $table->decimal('balance', 20, 2)->default(0);
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
        Schema::dropIfExists('supplier_accounts');
    }
}
