<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlgTagsTable extends Migration {

	public function up()
	{
		Schema::create('blg_tags', function(Blueprint $table) 
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->string('slug', 255)->unique()->index();
			$table->string('name', 255);
		});
	}

	public function down()
	{
		Schema::drop('blg_tags');
	}

}
