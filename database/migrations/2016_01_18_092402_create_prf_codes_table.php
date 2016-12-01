<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrfCodesTable extends Migration
{
	public function up()
	{
		Schema::create('prf_codes', function (Blueprint $table) {
			$table->increments('id');

			$table->string('title')->nullable();
			$table->boolean('used')->default(FALSE);
			$table->string('code')->unique();

			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('prf_codes');
	}
}
