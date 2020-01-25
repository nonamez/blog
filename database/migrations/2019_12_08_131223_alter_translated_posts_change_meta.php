<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTranslatedPostsChangeMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement('ALTER TABLE `nnm_blg_translated_posts` CHANGE `meta_keywords` `meta_keywords` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL  DEFAULT '';');
        DB::statement('ALTER TABLE `nnm_blg_translated_posts` CHANGE `meta_description` `meta_description` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL  DEFAULT '';');
        DB::statement('ALTER TABLE `nnm_blg_translated_posts` DROP `meta_title`;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
