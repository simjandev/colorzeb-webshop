<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 516);
            $table->text('description');
            $table->integer('category_id')->nullable();
            $table->string('category_name', 516);
            $table->string('images', 10240);
            $table->string('main_image', 1024);
            $table->text('parameter_settings');
            $table->boolean('has_custom_text_parameter');
            $table->integer('price');
            $table->integer('discount_price');
            $table->integer('discount');
            $table->integer('shipping_time');
            $table->boolean('active');
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
        Schema::dropIfExists('products');
    }
}
