<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrfWorksTable extends Migration
{
	public function up()
	{
		Schema::create('prf_works', function (Blueprint $table) {
			$table->increments('id');
			
			$table->string('title', 50);
			$table->text('description');

			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('prf_works');
	}
}
