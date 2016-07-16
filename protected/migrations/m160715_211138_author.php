<?php

class m160715_211138_author extends CDbMigration
{
	public function up()
	{
		$this->createTable('author', [
			'id' => 'pk',
			'firstname' => 'string not null',
			'lastname' => 'string not null',
		]);
	}

	public function down()
	{
		$this->dropTable('author');
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