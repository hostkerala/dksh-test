<?php

class m141215_021653_item_table_alter extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('item', 'item_amount', 'double');
        $this->alterColumn('item', 'item_amount_left', 'double');
        $this->alterColumn('item', 'item_total', 'double');
	}

	public function down()
	{
        $this->alterColumn('item', 'item_amount', 'integer');
        $this->alterColumn('item', 'item_amount_left', 'integer');
        $this->alterColumn('item', 'item_total', 'integer');
	}
}
