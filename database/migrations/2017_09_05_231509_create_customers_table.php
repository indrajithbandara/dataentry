<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('shipto', 255);
            $table->string('billto', 255);
            $table->string('buyer', 50);
            $table->string('email', 50);
            $table->string('phone', 15);
            $table->string('country', 15);
            $table->string('disclaimer', 255);
            $table->string('Comments', 255);
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
        Schema::dropIfExists('customers');
    }
}
