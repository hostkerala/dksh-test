<?php

class ClientareaModule extends CWebModule
{
	public $defaultController = 'dashboard';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'clientarea.components.*',
		));
             
		$this->setComponents(array(
			'errorHandler' => array(
				'errorAction' => 'clientarea/dashboard/error'
			),
		));
	}
}