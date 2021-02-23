<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlgTranslatedPostsTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blg_translated_posts_tags', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('post_id')->index();
            $table->foreign('post_id')->references('id')->on('blg_post_translated')->onDelete('cascade');
            
            $table->unsignedBigInteger('tag_id')->index();
            $table->foreign('tag_id')->references('id')->on('blg_tags')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blg_translated_posts_tags');
    }
}
