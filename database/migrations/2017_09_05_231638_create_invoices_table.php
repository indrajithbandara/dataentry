<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            // Invoice Fields
            $table->integer('inv_num')->unique();
            $table->date('date');
            $table->index('date');
            $table->json('customer');
            $table->string('cust_rel', 50);->nullable();
            $table->string('po_num', 30);
            $table->json('line_items');
            $table->decimal('misc_char', 7, 2)->nullable();
            $table->decimal('ship_fee', 7, 2)->nullable();
            $table->decimal('total', 7, 2);
            //Shipping Fields
            $table->integer('cartons')->nullable();
            $table->string('weight', 50)->nullable();
            $table->boolean('complete')->default(false);
            $table->string('appv_num', 50)->nullable();
            $table->string('supl_num', 50)->nullable();
            $table->string('carrier', 50)->nullable();
            $table->string('memo', 255)->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
