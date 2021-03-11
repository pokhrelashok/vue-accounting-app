<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('order_id', 64)->unique();

            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('customer_id')->nullable()->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->bigInteger('supplier_id')->nullable()->unsigned();
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->date('added_at');

            $table->string('name');
            $table->string('type', 16);

            $table->decimal('total_due',20,2);
            $table->decimal('total_price',20,2);
            $table->decimal('total_paid',20,2);
            $table->boolean('status')->default(0);
            $table->text('description')->nullable();

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
        Schema::dropIfExists('sales');
    }
}
