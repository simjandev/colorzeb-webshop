<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('email', 512);
            $table->text('user_comment');
            $table->text('admin_comment');
            $table->string('billing_name', 1024);
            $table->string('billing_tax_number', 1024);
            $table->string('billing_zip_code', 1024);
            $table->string('billing_city', 1024);
            $table->string('billing_address', 1024);
            $table->string('shipping_name', 1024);
            $table->string('shipping_zip_code', 1024);
            $table->string('shipping_city', 1024);
            $table->string('shipping_address', 1024);
            $table->string('shipping_phone', 1024);
            $table->integer('price');
            $table->integer('shipping_price');
            $table->boolean('payed')->default(false);
            $table->string('status', 256);
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
        Schema::dropIfExists('orders');
    }
}
