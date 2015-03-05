<?php

class m141229_073506_item_text_table_create extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{item_rich_text}}', [
			'id' => 'pk',
			'item_id' => 'INT(11) NOT NULL',
			'text_message' => 'TEXT NOT NULL',
			'total' => 'DECIMAL(16,4) DEFAULT 0'
		]);
		$this->addForeignKey('FK_item_rich_text_item_id',
			'{{item_rich_text}}', 'item_id',
			'{{item}}', 'id',
			'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('FK_item_rich_text_item_id', '{{item_rich_text}}');
		$this->dropTable('{{item_rich_text}}');
	}
}