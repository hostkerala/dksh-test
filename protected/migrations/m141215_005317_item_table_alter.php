<?php

class m141215_005317_item_table_alter extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item', 'created_by_id', 'integer');
        $this->addForeignKey('FK_item_created_by_id', 'item', 'created_by_id', 'user', 'id', 'CASCADE', 'RESTRICT');
	}

	public function down()
	{
        $this->dropForeignKey('FK_item_created_by_id', 'item');
        $this->dropColumn('item', 'created_by_id');
	}
}
