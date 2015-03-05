<?php

class m141215_111240_client_table_alter extends CDbMigration
{
	public function up()
	{
        $this->addColumn('client', 'client_pesel_type', 'tinyint');
	}

	public function down()
	{
        $this->dropColumn('client', 'client_pesel_type');
	}
}
