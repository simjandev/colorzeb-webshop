<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('billing_name', 1024)->default('');
            $table->string('billing_tax_number', 1024)->default('');
            $table->string('billing_zip_code', 1024)->default('');
            $table->string('billing_city', 1024)->default('');
            $table->string('billing_address', 1024)->default('');
            $table->string('shipping_name', 1024)->default('');
            $table->string('shipping_zip_code', 1024)->default('');
            $table->string('shipping_city', 1024)->default('');
            $table->string('shipping_address', 1024)->default('');
            $table->string('shipping_phone', 1024)->default('');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
