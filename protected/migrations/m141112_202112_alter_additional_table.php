<?php

class m141112_202112_alter_additional_table extends CDbMigration
{
	public function up()
	{
            CDbMigration::getDbConnection()->createCommand("ALTER TABLE `item_additional`  ADD CONSTRAINT `item_additional_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE;")->execute();
	}

	public function down()
	{
		
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