<?php

class m160715_113111_user extends CDbMigration
{
	public function up()
	{
		$this->createTable('user', [
			'id' => 'pk',
			'email' => 'string not null',
			'password' => 'string not null',
			'status' => 'integer not null',
			'created_at' => 'integer not null',
			'updated_at' => 'integer not null',
		]);
	}

	public function down()
	{
		$this->dropTable('user');
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