<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('inv_clients')->onDelete('restrict');

            $table->enum('status', ['draft', 'sent'])->default('draft');

            $table->text('notes')->nullable();

            $table->timestamps();
            
            $table->date('invoiced_at')->nullable();
            $table->date('due_until')->nullable();
            $table->date('paid_at')->nullable();
            $table->date('returned_at')->nullable();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_invoices');
    }
}
