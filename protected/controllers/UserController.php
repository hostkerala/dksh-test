<?php

class UserController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        $model = new LoginForm;
		
		if( !empty($_POST['LoginForm']) )
		{
			$model->attributes = $_POST['LoginForm'];
			if( $model->validate() && $model->login() )
			{
				$this->redirectAuthorizedUser();
			}
		}

		$this->render('login', array('model' => $model));
	}
	
	/**
	 * register new user
	 * login after registration successfull
	 */
	public function actionRegister()
	{
		$model = new User('register');
		
		if( !empty($_POST['User']) )
		{
			$model->attributes = $_POST['User'];
			
			$nohash_password = $model->user_password;
			if( $model->save() )
			{
				$login = new LoginForm();
				$login->username = $model->user_email;
				$login->password = $nohash_password;
				if( $login->login() )
				{
					$this->redirectAuthorizedUser();
				}
			}
		}
		
		$this->render('register', array('model' => $model));
	}

	/**
	 * do the redirect of authorized user.
	 * used in login/register actions
	 */
	protected function redirectAuthorizedUser()
	{
		$redirect_to = Html::url('/clientarea');
		if( Yii::app()->request->isAjaxRequest )
		{
			// render json
			$this->renderJSON(array('redirect', $redirect_to), 301);
		}
		else
		{
			$this->redirect( $redirect_to );
		}
		Yii::app()->end();
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
}