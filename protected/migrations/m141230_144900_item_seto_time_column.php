<?php

class m141230_144900_item_seto_time_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{item}}', 'item_seto_time', 'DATETIME DEFAULT NULL');
	}

	public function down()
	{
		$this->dropColumn('{{item}}', 'item_seto_time');
	}
}