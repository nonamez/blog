<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlgPostTranslatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blg_post_translated', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_post_id');
            $table->foreign('parent_post_id')->references('id')->on('blg_posts')->onDelete('cascade');

            $table->enum('locale', config('blog.locales'))->default('en');

            $table->enum('status', ['published', 'draft', 'hidden'])->default('draft');

            $table->timestamp('date');
            
            $table->boolean('markdown')->default(TRUE);

            $table->string('slug')->unique();

            $table->string('title');
            
            $table->longText('content');

            $table->string('meta_description')->default(NULL);
            $table->string('meta_keywords')->default(NULL);
            
            $table->timestamps();
            
            $table->unique(['parent_post_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blg_post_translated');
    }
}
