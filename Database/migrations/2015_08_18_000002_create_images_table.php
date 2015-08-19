<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateImagesTable extends Migration
{

	public function __construct()
	{
		// Get the prefix
		$this->prefix = Config::get('records.records_db.prefix', '');
	}


	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create($this->prefix . 'images', function(Blueprint $table) {

			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('user_id')->index();

			$table->string("image_file_name")->nullable();
			$table->integer("image_file_size")->nullable();
			$table->string("image_content_type")->nullable();
			$table->timestamp("image_updated_at")->nullable();


// 			$table->string('fileName', 225)->nullable();
// 			$table->string('path',225)->nullable();
// 			$table->string('group', 30)->nullable();
// 			$table->smallInteger('order')->default(0);
// 			$table->smallInteger('visibility')->default(1);
// 			$table->string('mime', 225)->nullable();
// 			$table->string('extension', 3)->nullable();

//			$table->rememberToken();

			$table->softDeletes();
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
		Schema::drop($this->prefix . 'images');
	}

}
