<?php

class m141112_201304_additional_data_table extends CDbMigration
{
	public function up()
	{
            CDbMigration::getDbConnection()->createCommand("CREATE TABLE IF NOT EXISTS `item_additional` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(80) NOT NULL,
                `yii` varchar(80) DEFAULT NULL,
                `unit` varchar(16) DEFAULT NULL,
                `quantity` int(11) DEFAULT NULL,
                `netto1` double DEFAULT NULL,
                `rate` int(11) DEFAULT NULL,
                `netto2` double DEFAULT NULL,
                `total` double DEFAULT NULL,
                `item_id` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `item_id` (`item_id`)
              ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;")->execute();
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