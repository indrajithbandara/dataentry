<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('router_num');
            $table->string('part_num', 50);
            $table->string('po_num', 50)->nullable();
            $table->string('customer', 100)->nullable();
            $table->integer('qty');
            $table->integer('stock_qty')->nullable();
            $table->integer('rating')->nullable();
            $table->enum('status', ['NIP', 'IP', 'II', 'A']); // Status: NIP = 'Not In Production', IP = 'In Production', II = 'In Inventory', A = 'Archive'
            $table->string('dept_name', 50)->nullable();
            $table->text('move_log')->nullable();
            $table->date('date');
            $table->date('date_in_inv')->nullable();
            $table->integer('placement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routers');
    }
}
