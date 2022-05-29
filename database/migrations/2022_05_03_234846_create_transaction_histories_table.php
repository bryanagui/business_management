<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->bigInteger('transaction_id')->nullable();
            $table->integer('product_id');
            $table->longText('name');
            $table->string('category');
            $table->bigInteger('discount')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('quantity');
            $table->bigInteger('amount');
            $table->bigInteger('refunded')->default(0);
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
        Schema::dropIfExists('transaction_histories');
    }
}
