<?php
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'UserController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			array('username' , 'email'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
		);
	}

	#Declares attribute labels.
	public function attributeLabels()
	{
		return array(
			'username' => Yii::t('app','E-mail'),
			'password' => Yii::t('app','Password'),
		);
	}


	# Logs in the user using the given username and password in the model.
	# @return boolean whether login is successful
	public function login()
	{
		if($this->_identity === null)
		{
			$this->_identity = new UserIdentity($this->username, $this->password);
			$this->_identity->authenticate();
		}

		if($this->_identity->errorCode === UserIdentity::ERROR_NONE)
		{
			$duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
			Yii::app()->user->login($this->_identity, $duration);
			return true;
		}
		else
		{
			$this->addError('username', "Sorry, but we can't find the account with specified username and password.");
			return false;
		}	
	}

}
