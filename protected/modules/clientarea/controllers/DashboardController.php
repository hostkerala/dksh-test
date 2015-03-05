<?php

class DashboardController extends ClientareaController
{    
        public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionCalendar()
	{
		$events = array();

        $criteria = new CDbCriteria;
        $criteria->with = array('client' => array('select' => false));
        $criteria->compare('client.client_user_id', Yii::app()->user->id);
		$tests = Item::model()->findAll($criteria);
		
		foreach($tests as $item)
		{
			$events[] = array(
				'title' => $item->item_name,
				'start' => $item->item_create_time,
				'end' => $item->item_submit_time,
			);
		}

		$this->render('calendar', array('events' => $events));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
}