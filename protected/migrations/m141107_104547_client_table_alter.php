<?php

class m141107_104547_client_table_alter extends CDbMigration
{
	public function up()
	{
		$this->addColumn('client', 'client_country', 'string');
		$this->addColumn('client', 'client_city', 'string');
		$this->addColumn('client', 'client_street', 'string');
		$this->addColumn('client', 'client_postcode', 'string');
		$this->addColumn('client', 'client_nip', 'integer');
		$this->addColumn('client', 'client_pesel', 'integer');
		$this->addColumn('client', 'client_regon', 'integer');
		$this->addColumn('client', 'client_other', 'string');
		$this->addColumn('client', 'client_email', 'string');
	}

	public function down()
	{
		$this->dropColumn('client', 'client_country');
		$this->dropColumn('client', 'client_city');
		$this->dropColumn('client', 'client_street');
		$this->dropColumn('client', 'client_postcode');
		$this->dropColumn('client', 'client_nip');
		$this->dropColumn('client', 'client_pesel');
		$this->dropColumn('client', 'client_regon');
		$this->dropColumn('client', 'client_other');
		$this->dropColumn('client', 'client_email');
		return true;
	}
}