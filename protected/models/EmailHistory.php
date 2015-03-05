<?php

/**
 * This is the model class for table "email_history".
 *
 * The followings are the available columns in table 'email_history':
 * @property integer $id
 * @property integer $user_id
 * @property string $from
 * @property string $to
 * @property string $subject
 * @property string $cc
 * @property string $sent_date_time
 * @property string $item_ids
 * @property integer $attach_pdf
 * @property integer $attach_customer_statement
 * @property string $attach_files
 * @property string $body
 */
class EmailHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'email_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, from, to, subject', 'required'),
			array('user_id, attach_pdf, attach_customer_statement', 'numerical', 'integerOnly'=>true),
			array('subject', 'length', 'max'=>254),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, from, to, subject, cc, sent_date_time, item_ids, attach_pdf, attach_customer_statement, attach_files, body', 'safe', 'on'=>'search'),
                        array('id','required','on'=>'reminder'),
                        array('user_id, from, to, subject, cc, sent_date_time, item_ids, attach_pdf, attach_customer_statement, attach_files, body', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'from' => 'From',
			'to' => 'To',
			'subject' => 'Subject',
			'cc' => 'Cc',
			'sent_date_time' => 'Sent Date Time',
			'item_ids' => 'Item Ids',
			'attach_pdf' => 'Attach Pdf',
			'attach_customer_statement' => 'Attach Customer Statement',
			'attach_files' => 'Attach Files',
			'body' => 'Body',
		);
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('cc',$this->cc,true);
		$criteria->compare('sent_date_time',$this->sent_date_time,true);
		$criteria->compare('item_ids',$this->item_ids,true);
		$criteria->compare('attach_pdf',$this->attach_pdf);
		$criteria->compare('attach_customer_statement',$this->attach_customer_statement);
		$criteria->compare('attach_files',$this->attach_files,true);
		$criteria->compare('body',$this->body,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmailHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 27-01-2015
    * Time :12:00 AM
    * Function to Save the message history
    * @param $folderName
    * @param $model EmailHistory
    * @return bool
    */
    
    public function saveHistory($folderName,$model)
    {
        $emailHistory = new EmailHistory;
        $emailHistory->user_id = yii::app()->user->id;
        $emailHistory->from = $model->from;
        $emailHistory->to = $model->to;
        $emailHistory->cc = $model->cc;
        $emailHistory->subject = $model->subject;
        $emailHistory->body = $model->body;
        $model->selected_items = is_array($model->selected_items) ? implode (", ", $model->selected_items) : $model->selected_items;
        $emailHistory->item_ids = $model->selected_items;
        $emailHistory->attach_pdf = $model->attach_pdf;
        $emailHistory->attach_customer_statement = $model->attach_customer_statement;
        $emailHistory->attach_files = $folderName;

        if($emailHistory->save())
        {
            return true;
        }
        else
        {
            return false;
        }  
    }  
    
    /**
     * Created By Roopan v v <yiioverflow@gmail.com>
     * Date : 27-01-2015
     * Time :12:00 AM
     * Function to Set to/cc addresses to the YiiMailMessage object
     * @param $to, $cc String
     * @param $message YiiMailMessage
     * @return YiiMailMessage
     */
    
    public static function messageSetToCC($to,$cc,$message)
    {
        $toArray =  explode( ',', $to);
        $ccArray =  explode( ',', $cc); 
        
        foreach($toArray as $to)
        {
            $message->addTo($to);                                
        }
        
        if($cc)
        {
            foreach($ccArray as $cc)
            {
                $message->addCc($cc);                                
            } 
        }
        return $message;
    } 
}
