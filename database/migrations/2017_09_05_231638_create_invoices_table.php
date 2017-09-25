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
            $table->integer('inv_num')->unique();
            $table->date('date');
            $table->index('date');
            // Copy of Customer in customers table
            $table->string('customer', 50);
            $table->string('name', 50);
            $table->string('shipto', 255);
            $table->string('billto', 255);
            $table->string('buyer', 50);
            $table->string('email', 50);
            $table->string('phone', 25);
            $table->string('country', 15);
            $table->string('disclaimer', 255)->nullable();
            $table->string('comments', 255)->nullable();
            // End of customer copy
            $table->string('po_num', 30);
            // Start of Line item entries x 7
            // ============================== One
            $table->string('li_one', 15);
            $table->string('product_one', 25);
            $table->integer('qty_one');
            $table->decimal('unit_one', 5, 2);
            $table->decimal('extended_one', 7, 2);
            // ============================== Two
            $table->string('li_two', 15)->nullable();
            $table->string('product_two', 25)->nullable();
            $table->integer('qty_two')->nullable();
            $table->decimal('unit_two', 5, 2)->nullable();
            $table->decimal('extended_two', 7, 2)->nullable();
            // ============================== Three
            $table->string('li_three', 15)->nullable();
            $table->string('product_three', 25)->nullable();
            $table->integer('qty_three')->nullable();
            $table->decimal('unit_three', 5, 2)->nullable();
            $table->decimal('extended_three', 7, 2)->nullable();
            // ============================== Four
            $table->string('li_four', 15)->nullable();
            $table->string('product_four', 25)->nullable();
            $table->integer('qty_four')->nullable();
            $table->decimal('unit_four', 5, 2)->nullable();
            $table->decimal('extended_four', 7, 2)->nullable();
            // ============================== Five
            $table->string('li_five', 15)->nullable();
            $table->string('product_five', 25)->nullable();
            $table->integer('qty_five')->nullable();
            $table->decimal('unit_five', 5, 2)->nullable();
            $table->decimal('extended_five', 7, 2)->nullable();
            // ============================== Six
            $table->string('li_six', 15)->nullable();
            $table->string('product_six', 25)->nullable();
            $table->integer('qty_six')->nullable();
            $table->decimal('unit_six', 5, 2)->nullable();
            $table->decimal('extended_six', 7, 2)->nullable();
            // ============================== Seven
            $table->string('li_seven', 15)->nullable();
            $table->string('product_seven', 25)->nullable();
            $table->integer('qty_seven')->nullable();
            $table->decimal('unit_seven', 5, 2)->nullable();
            $table->decimal('extended_seven', 7, 2)->nullable();
            // End of Line item entries
            $table->decimal('total', 7, 2);
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
