<?php

/**
 * SendMailForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class SendMailForm extends CFormModel
{
	public $from;
	public $to;
	public $cc;
	public $subject;
	public $body;
        public $selected_items;
        public $attach_customer_statement;
        public $attach_pdf;
        public $attach_files;


	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// subject, to and from are required
			array('from,to,subject', 'required'),
                       // from,to,cc has to be a valid email address
                        array('from', 'email'),
			array('to,cc', 'validateEmail'),
                        array('body,selected_items,attach_customer_statement,attach_pdf,attach_files', 'safe'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'from'=>'From',
                        'to'=>'Send To',
                        'cc'=>'CC',
                        'subject'=>'Subject',
                        'attach_customer_statement'=>'Attach Customer Statement',
                        'attach_pdf'=>'Attach PDF',
                        'attach_files'=>'Attach Files',
                        'body'=>'&nbsp;'
		);
	}
        
        
        /**
        * Created By Roopan v v <yiioverflow@gmail.com>
        * Date : 26-01-2015
        * Time 04:00 PM
        * Function to Validate email arrays
        */
        
        public function validateEmail($attribute,$params)
        {
            if($this->$attribute)
            {
                $emailArray =  explode( ',', $this->$attribute);    
                foreach($emailArray as $email)
                {
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
                    {
                        $this->addError($attribute,'Incorrect Email Entered');                    
                    }     
                }
            }
        }
        
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 26-01-2015
    * Time :10:30 AM
    * Function to Generate the Randon string for the directory name to upload
    * @param  Intiger $length
    * @return String
    */
    
    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
        
    }
    
    /**
     * Created By Roopan v v <yiioverflow@gmail.com>
     * Date : 27-01-2015
     * Time :12:00 AM
     * Function to Upload Files
     * @param $tmpName array
     * @param $fileName array
     * @return bool | $folderName string
     */
    
    public static function uploadFiles($fileName,$tmpName)
    {
        try
        {
            $folderName  = self::generateRandomString();

            for($i=0; $i<count($fileName); $i++) {

                $tmpFilePath = $tmpName[$i];

                //Make sure we have a filepath
                if ($tmpFilePath != "")
                {                
                    if(!is_dir(yii::app()->params['uploadDir'].DIRECTORY_SEPARATOR.$folderName)) 
                    {                     
                        mkdir(yii::app()->params['uploadDir'].DIRECTORY_SEPARATOR.$folderName,0777);                                     
                    }
                    //Setup our new file path
                    $newFilePath = yii::app()->params['uploadDir'].DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR.$fileName[$i];
                    move_uploaded_file($tmpFilePath, $newFilePath);                
                }
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return false;
        }
        return $folderName;
    }     
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 27-01-2015
    * Time :01:00 AM
    * Function to Attach Extra files with Mail
    * @param $folderName string
    * @param $message YiiMailMessage
    * @return YiiMailMessage object
    */

    
    public static function attachFiles($folderName,$message)
    {
        if ($handle = opendir(yii::app()->params['uploadDir'].DIRECTORY_SEPARATOR.$folderName))
        {
             while (false !== ($entry = readdir($handle))) {

                 if ($entry != "." && $entry != "..") {
                    $message->attach(Swift_Attachment::fromPath(yii::app()->params['uploadDir'].DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR.$entry)->setFilename($entry));
                 }
             }
         closedir($handle);
        }
        return $message;    
    }
    
}