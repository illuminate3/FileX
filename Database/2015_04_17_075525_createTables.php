<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('partnerCode', 30)->unique();
			$table->string('companyName', 100);
			$table->string('name', 30);
			$table->string('lastName', 30);
			$table->string('tel',100);
			$table->string('fax',100);
			$table->string('email',100);
			$table->string('street', 40);
			$table->string('houseNumber', 20);
			$table->string('city', 100);
			$table->string('zip', 16);
			$table->string('vat', 30);
			$table->string('password', 60);
			$table->smallInteger('level');
			$table->string('group', 30)->default(0);
			$table->string('folder', 225);
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('managers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('partnerCode', 30);
			$table->string('buildingCode', 30);
			$table->tinyInteger('relation')->default(0);
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('buildings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('buildingCode', 30)->unique();
			$table->string('owner', 30);
			$table->text('name');
			$table->string('street', 40);
			$table->string('houseNumber', 20);
			$table->string('zip',16);
			$table->string('city',100);
			$table->string('tel',100)->nullable();
			$table->string('fax',100)->nullable();
			$table->string('email',100)->nullable();
			$table->string('url',200)->nullable();
			$table->text('description')->nullable();
			$table->text('mapcoord1')->nullable();
			$table->text('mapcoord2')->nullable();
			$table->string('slug',225);
			$table->tinyInteger('type')->default(2);
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('folders', function(Blueprint $table) {
			$table->increments('id');
			$table->string('owner', 30);
			$table->string('name', 225);
			$table->string('path',225);
			$table->string('group', 30);
			$table->smallInteger('order')->default(0);
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('files', function(Blueprint $table) {
			$table->increments('id');
			$table->string('owner', 30);
			$table->string('name', 225);
			$table->string('fileName', 225);
			$table->string('path',225);
			$table->string('group', 30);
			$table->smallInteger('order')->default(0);
			$table->string('mime', 225);
			$table->string('extension', 3);
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('documents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('owner', 30);
			$table->string('name', 225);
			$table->string('fileName', 225);
			$table->string('path',225);
			$table->string('group', 30);
			$table->smallInteger('order')->default(0);
			$table->smallInteger('visibility')->default(1);
			$table->string('mime', 225);
			$table->string('extension', 3);
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('notes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('owner', 30);
			$table->string('name', 225);
			$table->text('content');
			$table->string('group', 30);
			$table->smallInteger('urgent');
			$table->smallInteger('visibility');
			$table->dateTime('created');
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('owner', 30);
			$table->string('name', 225);
			$table->text('content');
			$table->string('slug')->nullable();
			$table->string('group', 30);
			$table->smallInteger('visibility');
			$table->dateTime('created');
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('content', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('owner', 30);
			$table->string('name', 225);
			$table->text('content');
			$table->smallInteger('visibility');
			$table->string('group', 30)->default(0);
			$table->dateTime('created');
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('menu', function(Blueprint $table){
			$table->increments('id');
			$table->string('owner', 30);
			$table->string('name', 225);
			$table->text('link')->nullable();
			$table->string('slug')->nullable();
			$table->smallInteger('level')->nullable();
			$table->smallInteger('order')->nullable()->default(0);
			$table->smallInteger('visibility');
			$table->dateTime('created');
			$table->rememberToken();
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
		Schema::drop('users');
		Schema::drop('managers');
		Schema::drop('buildings');
		Schema::drop('folders');
		Schema::drop('files');
		Schema::drop('documents');
		Schema::drop('notes');
		Schema::drop('pages');
		Schema::drop('content');
		Schema::drop('menu');
	}

}
