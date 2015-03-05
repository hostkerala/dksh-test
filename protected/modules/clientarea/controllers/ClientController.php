<?php

class ClientController extends ClientareaController
{
        
        public function filters()
	{
		$filters = parent::filters();
		// add ajax filter for all requests
		$filters[] = 'ajaxRequest';
		
		return $filters;
	}
	
	public function actionAjaxClientAdditionalFields( $item_id, $client_id )
	{
		$item = empty($item_id)? new Item() : Item::model()->findByPk($item_id);
		if( empty($item) ){
			Yii::app()->user->setFlass('error', 'Bad request');
			$this->renderJSON(array('null'), 400);
		}
		
		$model = is_numeric($client_id)? Client::model()->findByPk($client_id) : new Client();
		
		$form = $this->renderPartial('_client_additional_fields', array('model' => $model, 'item_id' => $item_id), true, false);
		
		$this->renderJSON(array('replaceHtml', 'div.item_form_'.$item_id.' div.client_fields', 'content' => $form));
	}
}