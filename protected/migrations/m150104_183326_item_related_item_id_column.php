<?php

class m150104_183326_item_related_item_id_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{item}}', 'item_related_id', 'INT(11) DEFAULT NULL');
	}

	public function down()
	{
		$this->dropColumn('{{item}}', 'item_related_id');
	}
}