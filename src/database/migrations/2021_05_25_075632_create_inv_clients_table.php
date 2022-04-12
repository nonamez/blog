<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_clients', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('name', 100);

            $table->string('address', 100)->nullable()->default(NULL);
            $table->string('city', 100)->nullable()->default(NULL);
            $table->string('country', 100)->nullable()->default(NULL);
            
            $table->string('company_code', 30)->nullable()->default(NULL);
            $table->string('vat_code', 30)->nullable()->default(NULL);

            $table->string('email', 50)->nullable()->default(NULL);
            $table->string('phone', 50)->nullable()->default(NULL);
            $table->string('url', 50)->nullable()->default(NULL);

            $table->timestamps();

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
        Schema::dropIfExists('inv_clients');
    }
}
