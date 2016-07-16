<?php

class m160715_211145_books extends CDbMigration
{
	public function up()
	{
		$this->createTable('book', [
			'id' => 'pk',
			'name' => 'string not null',
			'date_create' => 'integer not null',
			'date_update' => 'integer not null',
			'preview' => 'string',
			'date' => 'integer not null',
			'author_id' => 'integer not null',
			'status' => 'integer not null',
		]);
	}

	public function down()
	{
		$this->dropTable('book');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}