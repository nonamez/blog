<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlgFilesTable extends Migration {

	public function up()
	{
		Schema::create('blg_files', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('local_name');
			$table->integer('post_id')->unsigned()->nullable()->index();
			$table->timestamps();
			
			$table->foreign('post_id')->references('id')->on('blg_translated_posts');
		});
	}

	public function down()
	{
		Schema::drop('blg_files');
	}
}
