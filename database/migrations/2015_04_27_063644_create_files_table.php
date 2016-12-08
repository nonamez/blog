<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->increments('id');

            $table->string('name');
            $table->string('original_name')->nullable()->default(NULL);
            $table->text('description')->nullable()->default(NULL);

            $table->string('remote_url')->nullable()->default(NULL);

            $table->integer('fileable_id')->unsigned()->nullable()->default(NULL);
            $table->string('fileable_type')->nullable()->default(NULL);
            
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('files');
	}
}
