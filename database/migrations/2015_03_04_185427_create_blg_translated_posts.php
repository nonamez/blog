<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlgTranslatedPosts extends Migration {

	public function up()
	{
		Schema::create('blg_translated_posts', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id')->unsigned();

			$table->integer('parent_post_id')->unsigned()->index();
			$table->foreign('parent_post_id')->references('id')->on('blg_posts')->onDelete('cascade');

			$table->enum('locale', config('app.locales'))->default('en');
			$table->enum('status', ['published', 'draft'])->default('draft');

			$table->string('slug', 255)->unique();

			$table->string('icon')->default('fa fa-align-left');

			$table->string('title', 255);
			
			$table->longText('content');

			$table->string('meta_title', 255)->default(NULL);
			$table->string('meta_description', 255)->default(NULL);
			$table->string('meta_keywords', 255)->default(NULL);
			
			$table->timestamps();
			
			$table->unique(['parent_post_id','locale']);
		});
	}

	public function down()
	{
		Schema::drop('blg_translated_posts');
	}

}
