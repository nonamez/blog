<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlgTranslatedPostsTable extends Migration
{
	public function up()
	{
		$prefix = DB::getTablePrefix();
		
		DB::statement("ALTER TABLE `{$prefix}blg_translated_posts` CHANGE COLUMN `status` `status` ENUM('published','draft','hidden') NOT NULL DEFAULT 'draft' COLLATE 'utf8_unicode_ci' AFTER `locale`;");
	}

	public function down()
	{
		$prefix = DB::getTablePrefix();

		DB::statement("ALTER TABLE `{$prefix}blg_translated_posts` CHANGE COLUMN `status` `status` ENUM('published','draft') NOT NULL DEFAULT 'draft' COLLATE 'utf8_unicode_ci' AFTER `locale`;");
	}
}
