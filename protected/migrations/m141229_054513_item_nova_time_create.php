<?php

class m141229_054513_item_nova_time_create extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{item}}', 'item_nova_time', 'DATETIME DEFAULT NULL');
	}

	public function down()
	{
		$this->dropColumn('{{item}}', 'item_nova_time');
	}
}