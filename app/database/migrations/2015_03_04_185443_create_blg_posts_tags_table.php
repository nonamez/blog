<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlgPostsTagsTable extends Migration {

	public function up()
	{		
		Schema::create('blg_posts_tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('post_id')->unsigned()->index();
			$table->foreign('post_id')->references('id')->on('blg_translated_posts')->onDelete('cascade');
			$table->integer('tag_id')->unsigned()->index();
			$table->foreign('tag_id')->references('id')->on('blg_tags')->onDelete('cascade');

			$table->unique(['post_id','tag_id']);
		});
	}

	public function down()
	{
		Schema::drop('blg_posts_tags');
	}

}
