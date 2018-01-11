<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseorders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_num', 50);
            $table->date('due_date');
            $table->date('will_ship');
            $table->integer('rating')->nullable();
            $table->enum('sooner', ['Yes', 'No']);
            $table->string('customer', 100);
            $table->string('part_num', 50);
            $table->integer('qty');
            $table->enum('status', ['Open', 'Closed']);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('purchaseorders');
    }
}
