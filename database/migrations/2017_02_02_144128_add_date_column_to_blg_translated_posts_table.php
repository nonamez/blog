<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateColumnToBlgTranslatedPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blg_translated_posts', function (Blueprint $table) {
            $table->timestamp('date')->after('status');
        });

        DB::table('blg_translated_posts')->update(['date' => DB::raw('`created_at`')]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blg_translated_posts', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
}
