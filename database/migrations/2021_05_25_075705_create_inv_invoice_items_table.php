<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_invoice_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('invoice_id');

            $table->foreign('invoice_id')->references('id')->on('inv_invoices')->onDelete('restrict');

            $table->decimal('sum', 9, 2);
            $table->unsignedTinyInteger('count')->default(1);

            $table->text('comment')->nullable();

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
        Schema::dropIfExists('inv_invoice_items');
    }
}
