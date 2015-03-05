<?php

class AccountController extends ClientareaController 
{

    
        /**
	 * user profile form
	 */    
    public function actionIndex() 
	{

        $model = User::model()->findByPk(Yii::app()->user->id);
		$model->scenario = 'update';

        if (isset($_POST['User'])) 
		{
			$model->attributes = $_POST['User'];
			if( $model->validate() )
			{
				if( !empty($model->new_password) )
				{
					$model->user_password = $model->hashPassword( $model->new_password );
				}
				
				$model->save();
				$this->redirect( Html::url('/clientarea/dashboard') );
				Yii::app()->end();
			}
		}

        $this->render('settings', array('model' => $model));
    }
}