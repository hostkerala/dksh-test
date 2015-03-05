<?php

class m141230_150703_item_back_amount_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{item}}', 'item_back_amount', 'DOUBLE DEFAULT NULL');
	}

	public function down()
	{
		$this->dropColumn('{{item}}', 'item_back_amount');
	}
}