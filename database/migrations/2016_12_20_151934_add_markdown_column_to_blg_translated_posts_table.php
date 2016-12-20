<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMarkdownColumnToBlgTranslatedPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blg_translated_posts', function (Blueprint $table) {
            $table->boolean('markdown')->default(TRUE)->after('status');
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
            $table->dropColumn('markdown');
        });
    }
}
