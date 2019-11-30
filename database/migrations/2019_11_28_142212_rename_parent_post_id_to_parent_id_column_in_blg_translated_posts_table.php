<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameParentPostIdToParentIdColumnInBlgTranslatedPostsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('blg_translated_posts', function (Blueprint $table) {
			DB::statement('ALTER TABLE `nnm_blg_translated_posts` CHANGE `parent_post_id` `parent_id` INT(10)  UNSIGNED  NOT NULL;');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('blg_translated_posts', function (Blueprint $table) {
			DB::statement('ALTER TABLE `nnm_blg_translated_posts` CHANGE `parent_id` `parent_post_id` INT(10)  UNSIGNED  NOT NULL;');
		});
	}
}
