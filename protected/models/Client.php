<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property integer $id
 * @property integer $client_user_id
 * @property string $client_name
 * @property string $client_create_time
 * @property string $client_country
 * @property string $client_city
 * @property string $client_street
 * @property string $client_postcode
 * @property integer $client_nip
 * @property integer $client_pesel
 * @property integer $client_regon
 * @property string $client_other
 * @property string $client_email
 * @property integer $client_pesel_type
 * 
 * The followings are the available model relations:
 * @property User $user
 * @property Item[] $items
 */
class Client extends CActiveRecord
{
    const PESEL_TYPE_NONE = 0;
    const PESEL_TYPE_NIP = 10;
    const PESEL_TYPE_REGON = 20;
    const PESEL_TYPE_OTHER = 30;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_name, client_country, client_city, client_street, client_postcode, client_pesel', 'required'),
			array('client_user_id, client_nip, client_pesel, client_regon', 'numerical', 'integerOnly'=>true),
			array('client_name, client_country, client_city, client_street, client_postcode, client_other, client_email', 'length', 'max'=>255),
			array('client_create_time', 'safe'),
            array('client_pesel_type', 'in', 'range' => array(self::PESEL_TYPE_NONE, self::PESEL_TYPE_NIP, self::PESEL_TYPE_REGON, self::PESEL_TYPE_OTHER)),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, client_user_id, client_name, client_create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'client_user_id'),
			'items' => array(self::HAS_MANY, 'Item', 'item_client_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'client_user_id' => 'Client User',
			'client_name' => 'Client Name',
			'client_create_time' => 'Client Create Time',
            'client_country' => 'Country',
            'client_city' => 'City',
            'client_street' => 'Street',
            'client_postcode' => 'Postcode',
            'client_pesel' => 'Pesel',
		);
	}

    /**
     * get key/value pairs of available pesel types
     * @return array
     */
    public static function getPeselTypeList()
    {
        return array(
            self::PESEL_TYPE_NONE => 'NONE',
            self::PESEL_TYPE_NIP => 'NIP',
            self::PESEL_TYPE_REGON => 'REGON',
            self::PESEL_TYPE_OTHER => 'OTHER',
        );
    }

    /**
     * getter for $this->peselAlias
     * @return string
     */
    public function getPeselTypeAlias()
    {
        $types = self::getPeselTypeList();
        if( !empty($types[ $this->client_pesel_type ]) )
        {
            return $types[ $this->client_pesel_type ];
        }

        return $this->client_pesel_type;
    }

	/**
	 * fill in default fields and has password before insert
	 * @return boolean
	 */
	protected function beforeSave()
	{
		if( parent::beforeSave() )
		{
			// fill "created" field if new record
			if( $this->isNewRecord )
			{
				$this->client_create_time = date('Y-m-d H:i:s');
			}
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * get id => client_name pairs
	 * @return array
	 */
	public static function getPairs()
	{
        $criteria = new CDbCriteria();
        $criteria->order = 'client_name ASC';
        $criteria->compare('client_user_id', Yii::app()->user->id);
		$pairs = array();
		$clients_ar = Client::model()->findAll($criteria);
		if( !empty($clients_ar) )
		{
			foreach($clients_ar as $client)
			{
				$pairs[ $client->id ] = $client->client_name;
			}
		}
		
		return $pairs;
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('client_user_id',$this->client_user_id);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('client_create_time',$this->client_create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Client the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
