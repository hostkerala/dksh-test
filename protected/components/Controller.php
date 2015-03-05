<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = 'main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();
	
	# set current language
	public function init()
	{
		parent::init();
	}
	
	protected function beforeAction( $action )
	{
		if( Yii::app()->request->isAjaxRequest )
		{
			$this->layout = '//layouts/ajax';
		}
		
		return parent::beforeAction($action);
	}

	/**
	 *	convert mixed data to json and stop script
	 *	@param	array	$actions	can be single action array, or multiple array of actions
	 *	@param 	mixed	$status_code	status code of response
	 *	@author
	 */
	public function renderJSON( $actions, $status_code = 200 )
	{
		$data = array(
			'status' => $status_code,
		);
		
		if( !empty($actions) && is_array($actions) )
		{
			// convert single action to multiple format
			$first_action = reset($actions);
			if( !is_array($first_action) )
			{
				$actions = array($actions);
			}
			$data['actions'] = $actions;
			
			foreach($actions as $action)
			{
				// check for redirect actions
				if( $action[0] == 'redirect' )
				{
					$redirect = true;
				}
			}
		}
		
		if( empty($redirect) )
		{
			if( Yii::app()->user->hasFlash('error') )
			{
				$data['flash']['error'] = Yii::app()->user->getFlash('error');
			}
			if( Yii::app()->user->hasFlash('status') )
			{
				$data['flash']['status'] = Yii::app()->user->getFlash('status');
			}
			if( Yii::app()->user->hasFlash('success') )
			{
				$data['flash']['success'] = Yii::app()->user->getFlash('success');
			}
		}
		
		header('Content-type: application/json');
		//echo CJavaScript::encode($mixed);
		echo CJSON::encode($data);
		Yii::app()->end(); 
	}	
}