<?php

class m141230_145408_item_rebo_time_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{item}}', 'item_rebo_time', 'DATETIME DEFAULT NULL');
	}

	public function down()
	{
		$this->dropColumn('{{item}}', 'item_rebo_time');
	}
}