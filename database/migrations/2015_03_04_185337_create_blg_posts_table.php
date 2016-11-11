<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlgPostsTable extends Migration {

	public function up()
	{
		Schema::create('blg_posts', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('blg_posts');
	}

}
