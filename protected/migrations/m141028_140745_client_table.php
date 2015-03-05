<?php

class m141028_140745_client_table extends CDbMigration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->getDbConnection()->getDriverName() === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		
		$this->createTable('client', array(
			'id' => 'pk',
			'client_user_id' => 'integer',
			'client_name' => 'string',
			'client_create_time' => 'datetime',
		), $tableOptions);
		// key to user table
		$this->addForeignKey('FK_client_user_id', 'client', 'client_user_id', 'user', 'id', 'SET NULL', 'RESTRICT');
		
		// add field to item to link with clients
		$this->addColumn('item', 'item_client_id', 'integer');
		$this->addForeignKey('FK_item_client_id', 'item', 'item_client_id', 'client', 'id', 'CASCADE', 'RESTRICT');
	}

	public function down()
	{
		$this->dropForeignKey('FK_item_client_id', 'item');
		$this->dropColumn('item', 'item_client_id');
		$this->dropTable('client');
		return true;
		//echo "m141028_140745_client_table does not support migration down.\n";
		//return false;
	}

}