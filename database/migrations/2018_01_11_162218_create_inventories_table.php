<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ist_num'); // ist = 'Inventory Ship Ticket'
            $table->string('part_num', 50)->nullable();
            $table->string('po_num', 50)->nullable();
            $table->string('customer', 100)->nullable();
            $table->enum('status',['Approved', 'Unapproved']);
            $table->json('boxes')->nullable();
            $table->text('log')->nullable();
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
