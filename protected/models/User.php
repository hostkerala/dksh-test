<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $user_category_id
 * @property string $user_name
 * @property string $user_email
 * @property integer $user_fav_number
 * @property string $user_password
 * @property string $user_create_time
 * @property string $user_submit_time
 * @property string $user_type
 * @property string $user_priority
 *
 * The followings are the available model relations:
 * @property Category $userCategory
 */
class User extends CActiveRecord
{
	public $terms;
	public $current_password;
	public $new_password;
	public $password_repeat;
	public $verifyCode;

	const PRIO_HIGH = 'high';
	const PRIO_LOW = 'low';
	
	private $_default_values = array(
		'user_type' => 'normal',
		'user_priority' => 'low',
	);
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_name, user_email, user_fav_number', 'required'),
			array('user_email', 'email'),
			array('user_category_id, user_fav_number', 'numerical', 'integerOnly'=>true),
			array('user_name, user_email', 'length', 'max'=>255),
			array('user_type', 'length', 'max'=>20),
			array('user_priority', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_category_id, user_name, user_email, user_fav_number, user_password, user_create_time, user_submit_time, user_type, user_priority', 'safe', 'on'=>'search'),
			
			// registration rules:
			array('terms', 'boolean'),
			array('user_email', 'unique', 'on' => 'register'),
			array('user_password, terms', 'required', 'on' => 'register'),
			array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'register'),
			
			array('new_password', 'compare', 'compareAttribute' => 'password_repeat', 'on' => 'update'),
			array('current_password', 'requiredConditional', 'relatedAttributes' => array('new_password', 'password_repeat')),
			array('current_password', 'validCurrentPassword'),
		);
	}
	
	public function requiredConditional($attribute, $params)
	{
		// if this attribute is not empty - validation successfull
		if( !empty($this->$attribute) ) return true;
		
		// check valid params
		if( empty($params['relatedAttributes']) ) return;
		if( !is_array($params['relatedAttributes']) ) $params['relatedAttributes'] = array($params['relatedAttributes']);
		
		// check related attributes for !empty (we already know, that current attribute is empty)
		foreach( $params['relatedAttributes'] as $rel_attribute )
		{
			if( !empty($this->$rel_attribute) )
			{
				$this->addError($attribute, Yii::t('app', '{attr} is required to update {rel_attr}', array(
							'{attr}' => $this->getAttributeLabel($attribute),
							'{rel_attr}' => $this->getAttributeLabel($rel_attribute),
						)
				));
				break;
			}
		}
	}
	
	public function validCurrentPassword($attribute, $params)
	{
		if( !empty($this->$attribute) && !$this->validatePassword($this->$attribute) )
		{
			$this->addError($attribute, Yii::t('app', '{attr} do not match your password', array(
					'{attr}' => $this->getAttributeLabel($attribute),
				)
			));
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
        return array(
            'userCategory' => array(self::BELONGS_TO, 'Category', 'category_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
        return array(
            'id' => 'ID',
            'user_category_id' => 'Category',
            'user_name' => 'Name',
            'user_email' => 'Email',
            'user_fav_number' => 'Favorite Number',
            'user_password' => 'Password',
            'user_create_time' => 'Create Time',
            'user_submit_time' => 'Submit Time',
            'user_type' => 'User Type',
            'user_priority' => 'User Priority',
			
			'terms' => 'I agree with terms',
			'current_password' => 'Current password',
			'new_password' => 'New password',
			'repeat_password' => 'Repeat password',
			'verifyCode' => 'Verification Code',
        );
	}
	
	/**
	 * @return array  key/value pairs of available priorities
	 */
	public static function getListPriorities()
	{
		return array(
			self::PRIO_LOW => self::PRIO_LOW,
			self::PRIO_HIGH => self::PRIO_HIGH,
		);
	}

	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return $this->hashPassword($password) === $this->user_password;
	}

	/**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public function hashPassword($password)
	{
		return md5($password);
	}
	
	/**
	 * fill in default fields and has password before insert
	 * @return boolean
	 */
	protected function beforeSave()
	{
		if( parent::beforeSave() )
		{
			// complete missing fields with default values
			foreach($this->attributes as $attr => $value)
			{
				if( is_null($value) && isset($this->_default_values[$attr]) )
				{
					$this->$attr = $this->_default_values[$attr];
				}
			}
			
			// hash password it present
			if( $this->isNewRecord && $this->user_password )
			{
				$this->user_password = $this->hashPassword($this->user_password);
			}
			
			// fill "created" field if new record
			if( $this->isNewRecord )
			{
				$this->user_create_time = date('Y-m-d H:i:s');
			}
			
			return true;
		}
		
		return false;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}        
}