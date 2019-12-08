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
        /* 13:13:00 localhost nonamez */ ALTER TABLE `nnm_blg_translated_posts` CHANGE `meta_keywords` `meta_keywords` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL  DEFAULT '';
        /* 13:12:51 localhost nonamez */ ALTER TABLE `nnm_blg_translated_posts` CHANGE `meta_description` `meta_description` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL  DEFAULT '';
        /* 13:12:48 localhost nonamez */ ALTER TABLE `nnm_blg_translated_posts` DROP `meta_title`;



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
