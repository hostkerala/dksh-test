<?php

class ClientareaController extends Controller
{	
	public $layout = 'webroot.themes.clientarea.views.layouts.main'; // Setting the layout path
    
        public function init()
        {
            yii::app()->theme = 'clientarea'; //Setting theme
            return parent::init();
        }  
	
	public function filters()
	{
		return array(
			'accessControl',
		);
	}	
	
	// all actions require auth user
	public function accessRules()
	{
		return array(
			array('deny',
				'users' => array('?'),
			),
			array('allow',
				'users' => array('@'),
			),
		);
	}
	
	public function filterAjaxRequest( $filterChain )
	{
		// block all requests which are not ajax
		if( ! Yii::app()->request->isAjaxRequest )
		{
			throw new CHttpException(400, 'Bad request.');
		}
		
		$filterChain->run();
	}
}