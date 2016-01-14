<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFilesTable extends Migration
{
	public function up()
	{
		Schema::rename('blg_files', 'files');

		Schema::table('files', function($table) {
			$table->enum('type', ['post', 'portfolio'])->default(NULL)->after('post_id');
		});

		DB::table('files')->update(['type' => 'post']);

		$prefix = DB::getTablePrefix();

		DB::statement("ALTER TABLE `{$prefix}files` CHANGE COLUMN `post_id` `parent_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `original_name`;");
	}

	public function down()
	{
		Schema::rename('files', 'blg_files');
		
		$prefix = DB::getTablePrefix();

		DB::statement("ALTER TABLE `{$prefix}blg_files` CHANGE COLUMN `parent_id` `post_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `original_name`;");
		DB::statement("ALTER TABLE `{$prefix}blg_files` DROP COLUMN `type`;");	
	}
}
