<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateDocumentsTable extends Migration
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

		Schema::create($this->prefix . 'documents', function(Blueprint $table) {

			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('user_id')->index();
//			$table->string('owner', 30)->nullable();
//			$table->string('name', 225)->nullable();
			$table->string('fileName', 225)->nullable();
			$table->string('path',225)->nullable();
//			$table->string('group', 30)->nullable();
			$table->smallInteger('order')->default(0);
			$table->smallInteger('visibility')->default(1);
			$table->string('mime', 225)->nullable();
			$table->string('extension', 3)->nullable();

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
		Schema::drop($this->prefix . 'documents');
	}

}
