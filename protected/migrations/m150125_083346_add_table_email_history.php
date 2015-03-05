<?php

class m150125_083346_add_table_email_history extends CDbMigration
{
	public function up()
	{
            
            $this->execute("CREATE TABLE IF NOT EXISTS `email_history` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `user_id` int(11) NOT NULL,
                            `from` text NOT NULL,
                            `to` text NOT NULL,
                            `subject` varchar(254) NOT NULL,
                            `cc` text NOT NULL,
                            `sent_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `item_ids` text NOT NULL,
                            `attach_pdf` int(11) NOT NULL DEFAULT '0',
                            `attach_customer_statement` int(11) NOT NULL DEFAULT '0',
                            `attach_files` text NOT NULL,
                            `body` text NOT NULL,
                            PRIMARY KEY (`id`)
                          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;"
                          );
            return true;
	}

	public function down()
	{
		$this->execute("DROP TABLE IF EXISTS `email_history`;");
                return true;
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