<?php

class ItemController extends ClientareaController {
    
    const LIST_ACTION_ROUTE = '/clientarea/item/list';

    public function filters() {
        $filters = parent::filters();
        // add ajax filter for all requests
        //	$filters[] = 'ajaxRequest';

        return $filters;
    }
         

    /**
     * load UI for item section (left menu and action buttons)
     *
     * @param int $categoryType Category type to show UI section
     */
    public function actionIndex($categoryType = Category::TYPE_DEFAULT) {
        $categories = Category::model()->findAllByAttributes(array(
            Category::ATTR_LEVEL => 0,
            'category_type' => $categoryType
        ));

        $this->render('index', array(
            'categories_root' => $categories,
            'categoryType' => $categoryType
        ));
    }

    /**
     * ajax action to load items list
     */
    public function actionList($categoryType = Category::TYPE_DEFAULT) {
        $categories_tree = Category::model()->findAllByAttributes(
            array('category_type' => $categoryType),
            array('order' => Category::ATTR_LEFT . ' ASC')
        );

        $this->render('list', array(
            'categories_tree' => $categories_tree,
        ));
    }

    /**
     * item create form, category id os required
     * @param integer $category_id
     */
    public function actionCreate($category_id, $item_id = false) {
        $category = Category::model()->findByPk($category_id);
        if (empty($category)) {
            throw new CHttpException(400, 'Bad request.');
        }

        $item = new Item('create');
        $client = null;
        $additional_data = array();
        $rich_text_data = array();
        $related_category = false;
        if($item_id) {
            $donorItem = Item::model()->findByPk($item_id);
            if($donorItem instanceof Item) {
                $item->cloneAttributes($donorItem, $category->id);
                $client = $donorItem->client;
                $client->id = false;
                $related_category = $donorItem->item_category_id;
            }
        }


        $item->item_category_id = $category->id;

        if (!empty($_POST['Item'])) {
            $item->attributes = $_POST['Item'];
            $client = $item->getClientByInput($_POST['Item']);
            $additional_data = $_POST['Item']['ItemAdditional'];
            $rich_text_data = $_POST['Item']['ItemRichText'];


            $rich_text_data_validate = $this->additionalDataValidate($rich_text_data, $category, 'ItemRichText', $related_category);
            $additional_data_validate = $this->additionalDataValidate($additional_data, $category, 'ItemAdditional', $related_category);

            // check item valid - then we can analyze item & client
            if ($item->validate() && $client->validate() && $additional_data_validate && $rich_text_data_validate) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $this->saveItemModel($item, $client, $additional_data, $rich_text_data);
                    $transaction->commit();

                    // notify user that all is okay and load list again
                    Yii::app()->user->setFlash('success', 'Item has been saved');
                    $this->renderJSON(array('refreshBlock', '#item-content', Html::url(self::LIST_ACTION_ROUTE)));
                } catch (Exception $e) { // an exception is raised if a query fails
                    $transaction->rollback();
                    //$item->addError('item_client_name', 'Database error: '.$e->getMessage());
                    Yii::app()->user->setFlash('error', 'Database error, please try again.');
                }
            }
        }

        $relatedCategoriesIds = $category->getRelationalCategories();
        $related_mode = !empty($relatedCategoriesIds);
        $relatedCategoriesModels = array();
        if($related_mode) {
            foreach($relatedCategoriesIds as $c)
                $relatedCategoriesModels[] = Category::model()->findByPk($c);
        }

        $this->render('create', array(
            'model' => $item,
            'client' => $client,
            'category' => $category,
            'additional_data' => $additional_data,
            'rich_text_data' => $rich_text_data,
            'form_file' => self::getFormFileNameByCategoryId($category, $related_category),
            'related_category' => $related_category,
            'related_mode' => $related_mode,
            'relatedCategoriesIds' => $relatedCategoriesIds,
            'relatedCategoriesModels' => $relatedCategoriesModels,
        ));
    }

    /**
     * save item model, check that client exists before that.
     * @param Item $item model to update
     * @param Client $client  model for client record to save
     */
    protected function saveItemModel($item, $client, $itemAdditional = array(), $richTextData = array()) {
        if (!$item->validate())
            return false;

        if (empty($item->item_client_id) && !empty($item->item_client_name)) {
            // create client
            $client->client_user_id = Yii::app()->user->id;
            $client->save();

            // update item
            $item->item_client_id = $client->id;
            $item->item_client_name = $client->client_name;
            $item->item_name = $client->client_name;
        } else {
            $client->save();
        }

        // update item
        if ($item->save(false)) {

            if(!empty($itemAdditional)) {
                $this->saveAdditionalData($itemAdditional, $item, 'ItemAdditional');
            }
            // Because I haven't time to refactor...
            if(!empty($richTextData)) {
                $this->saveAdditionalData($richTextData, $item, 'ItemRichText');
            }

            return true;
        }
        return false;
    }

    /**
     * @todo Refactor and move saving to model!!!
     * @param $itemAdditional
     * @param $item
     * @param string $class
     * @return array|bool
     */
    private function saveAdditionalData($itemAdditional, $item, $class = 'ItemAdditional')
    {
        $itemErrors = array();
        foreach ($itemAdditional as $_item) {

            $id = isset($_item['id']) ? $_item['id'] : 0;
            if (isset($_item['id'])) {
                unset($_item['id']);
            }
            $values = array_filter($_item);

            if (empty($values)) {
                if ($id !== 0) {
                    $itemModel = $class::model()->findByPk($id);
                    $itemModel->delete();
                }
                continue;
            }
            if ($id) {
                $itemModel = $class::model()->findByPk($id);
                $itemModel->attributes = $_item;
                if ($itemModel->validate()) {
                    $itemModel->save();
                } else {
                    $itemErrors[] = $itemModel->errors;
                    break;
                }
            } else {
                $itemModel = new $class();
                $itemModel->attributes = $_item;
                $itemModel->item_id = $item->id;
                if ($itemModel->validate()) {
                    $itemModel->save();
                } else {
                    $itemErrors[] = $itemModel->errors;
                    break;
                }
            }
        }

        return empty($itemErrors) ? true : $itemErrors;
    }

    /**
     * @param $itemAdditional
     * @param string $class Class to validate
     * @return bool
     */
    protected function additionalDataValidate($itemAdditional, Category $category, $class = 'ItemAdditional', $related_category_id = false) {
        if($class == 'ItemRichText' && $category->nested_parent != Category::ID_IN_4)
            return true;
        elseif($class == 'ItemAdditional' && (
            in_array($category->id, array(Category::ID_SUB_IN_1_2, Category::ID_SUB_IN_1_3)) ||
            ($category->id == Category::ID_SUB_IN_1_4 && $related_category_id == Category::ID_SUB_IN_1_2) ||
            ($category->id == Category::ID_SUB_IN_1_4 && $related_category_id == Category::ID_SUB_IN_1_3) ||
            $category->nested_parent == Category::ID_IN_4)
        )
        {
            return true;
        }

        $itemErrors = array();
        foreach ($itemAdditional as $_item) {
            $id = isset($_item['id']) ? $_item['id'] : 0;
            if (isset($_item['id'])) {
                unset($_item['id']);
            }
            $values = array_filter($_item);
            if (empty($values)) {
                continue;
            }
            if ($id) {
                $itemModel = $class::model()->findByPk($id);
                $itemModel->attributes = $_item;
                if (!$itemModel->validate()) {
                    $itemErrors[] = $itemModel->errors;
                }
            } else {
                $itemModel = new $class();
                $itemModel->attributes = $_item;

                if (!$itemModel->validate()) {
                    $itemErrors[] = $itemModel->errors;
                }
            }
        }
        if (!empty($itemErrors)) {
            return false;
        }
        return true;
    }

    /**
     * load data provider for given ids and print models
     */
    public function actionBulkView() {
        if (empty($_POST['ids']) || !is_array($_POST['ids'])) {
            throw new CHttpException(400, 'Bad request.');
        }

        $model = new Item('search');
        $model->unsetAttributes();
        $model->id = $_POST['ids'];

        $data_provider = $model->search();
        $data_provider->pagination = false;

        $this->render('bulkView', array('data_provider' => $data_provider));
    }

    /**
     * delete items
     */
    public function actionBulkDelete() {
        if (empty($_POST['ids']) || !is_array($_POST['ids'])) {
            throw new CHttpException(400, 'Bad request.');
        }

        foreach($_POST['ids'] as $id)
            Item::model()->findByPk($id)->delete();

        Yii::app()->user->setFlash('success', 'Item(s) has been deleted');
        $this->renderJSON(array('refreshBlock', '#item-content', Html::url(self::LIST_ACTION_ROUTE)));
    }

    /**
     * bulk update
     */
    public function actionBulkUpdate() {
        if ((empty($_POST['ids']) || !is_array($_POST['ids'])) && empty($_POST['Item'])) {
            throw new CHttpException(400, 'Bad request.');
        }

        $items = array();
        $clients = array();
        $additional_data = array();
        $rich_text_data = array();
        if (!empty($_POST['ids'])) {
            $items = Item::model()->findAllByAttributes(array('id' => $_POST['ids']));
            // hotfix: client names are empty in most of the record, we will try to fill them up with item_name instead
            foreach ($items as $item_id => $item) {
                if (empty($item->item_client_id)) {
                    $item->item_client_name = $item->item_name;
                    $clients[$item_id] = new Client();
                } else {
                    $clients[$item_id] = $item->client;
                }
                $_additional_data[$item_id] = ItemAdditional::model()->findAll('item_id=:item_id', array(':item_id' => $item->id));
                $_rich_text_data[$item_id] = ItemRichText::model()->findAll('item_id=:item_id', array(':item_id' => $item->id));
            }
            if (!empty($_additional_data)) {
                foreach ($_additional_data as $item_id => $row) {
                    foreach ($row as $item) {
                        foreach ($item as $key => $val) {
                            if ($key == 'item_id') {
                                continue;
                            }
                            $additional_data[$item_id][$item->item_id][$item->id][$key] = $val;
                        }
                    }
                }
            }
            if (!empty($_rich_text_data)) {
                foreach ($_rich_text_data as $item_id => $row) {
                    foreach ($row as $item) {
                        foreach ($item as $key => $val) {
                            if ($key == 'item_id') {
                                continue;
                            }
                            $rich_text_data[$item_id][$item->item_id][$item->id][$key] = $val;
                        }
                    }
                }
            }
        }

        if (!empty($_POST['Item'])) {
            $is_valid = true;
            $items = array();
            $clients = array();
            $additional_data = array();
            $rich_text_data = array();
            foreach ($_POST['Item'] as $id => $input) {
                $item = Item::model()->findByPk($id);
                $item->attributes = $input;
                $client = $item->getClientByInput($input);
                //		pa(array($item->attributes, $item->item_client_name));
                $is_valid &= $item->validate() && $client->validate();
                $is_valid &= $this->additionalDataValidate($input['ItemAdditional'], $item->category);
                $is_valid &= $this->additionalDataValidate($input['ItemAdditional'], $item->category, 'ItemRichText');
                $items[$id] = $item;
                $clients[$id] = $client;
                $additional_data[$id] = $input['ItemAdditional'];
                $rich_text_data[$id] = $input['ItemRichText'];
            }

            // if all records valid - then save
            if ($is_valid) {
                // we have multiple save here - so using transactions
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    foreach ($items as $item_id => $item) {
                        $this->saveItemModel($item, $clients[$item_id], $additional_data[$item_id], $rich_text_data[$item_id]);
                    }
                    $transaction->commit();

                    // notify user that all is okay and load list again
                    Yii::app()->user->setFlash('success', 'Items have been updated.');
                    $this->renderJSON(array('refreshBlock', '#item-content', Html::url(self::LIST_ACTION_ROUTE)));
                } catch (Exception $e) { // an exception is raised if a query fails
                    $transaction->rollback();
                    //$item->addError('item_client_name', 'Database error: '.$e->getMessage());
                    Yii::app()->user->setFlash('error', 'Database error, please try again.');
                }
            }
        }

        //pa($items,1);
        $this->render('bulkUpdate', array(
            'items' => $items,
            'clients' => $clients,
            'additional_data' => $additional_data,
            'rich_text_data' => $rich_text_data,
        ));
    }

    /**
     * Print items
     *
     * @throws CHttpException
     */
    public function actionPrint()
    {
        if (empty($_POST['ids']) || !is_array($_POST['ids'])) {
            throw new CHttpException(400, 'Bad request.');
        }

        $criteria = new CDbCriteria();
        $criteria->addInCondition('t.id', $_POST['ids']);
        $items = Item::model()->with('category', 'client', 'additional_data')->findAll($criteria);

        $this->render('print', array('items' => $items));
    }

    /**
     * Return form file to render
     * @param $category_id
     * @return string
     */
    public static function getFormFileNameByCategoryId(Category $category, $related_category_id = false)
    {
        $id = $category->id;
        switch($id) {
            case Category::ID_SUB_IN_1_2:
                $form_file = '_form_fields_12';
                break;
            case Category::ID_SUB_IN_1_3:
                $form_file = '_form_fields_13';
                break;
            case Category::ID_SUB_IN_1_4:
                if($related_category_id == Category::ID_SUB_IN_1_2)
                    $form_file = '_form_fields_1_4-1_2';
                elseif($related_category_id == Category::ID_SUB_IN_1_3)
                    $form_file = '_form_fields_1_4-1_3';
                else
                    $form_file = '_form_fields_1_4-1_1';
                break;
            case Category::ID_SUB_IN_1_5:
                $form_file = '_form_fields_15';
                break;
            default:
                $form_file = '_form_fields';
                break;
        }

        if($category->nested_parent == Category::ID_IN_4)
            $form_file = '_form_fields_category_4';

        return '_form/'.$form_file;
    }

    public function actionItemAttributesJson($id)
    {
        $model = Item::model()->findByPk($id);
        if(!$model instanceof Item || $model->client->user->id != Yii::app()->user->id)
            echo CJSON::encode(false);
        $out = array(
            'model' => $model->attributes,
            'client' => $model->client->attributes,
            'additional' => array(),
            'rich_text' => array(),
        );

        $additional = $model->additional_data;
        if(!empty($additional))
            foreach($additional as $item)
                $out['additional'][] = $item->attributes;

        $rich_texts = $model->rich_texts;
        if(!empty($rich_texts))
            foreach($rich_texts as $item)
                $out['rich_text'][] = $item->attributes;

        $dateAttributes = array('item_create_time', 'item_submit_time', 'item_end_time', 'item_nova_time');
        foreach($out['model'] as $k=>$v) {
            if(in_array($k, $dateAttributes)) {
                $date = new DateTime($v);
                $out['model'][$k] = $date->format('d/m/Y');
            }
        }

        echo CJSON::encode($out);
    }
        
    /**
     * Created By Roopan v v <yiioverflow@gmail.com>
     * Date : 24-01-2015
     * Time :10:00 AM
     * Functin to Send Email, Save Email in EmailHistory
     * @param Integer $categoryType
     */
    
    public function actionSendEmail($categoryType = Category::TYPE_DEFAULT)
    {  
        $params = array();
        $folder_name ="";
        $model = new SendMailForm;
        $user = User::model()->findByPk(yii::app()->user->id);
        $model->from = $user->user_email; 
        $model->subject = "Item from ".$user->user_name; 
        
        $categories_tree = Category::model()->findAllByAttributes(
            array('category_type' => $categoryType),
            array('order' => Category::ATTR_LEFT . ' ASC')
        );  

        if(isset($_POST['ids']) && !empty($_POST['ids']))
        {
            $model->selected_items = $_POST['ids'];              
        }
        
        $params =   array(
                        'date' => date('d M Y'),
                        'amount'=> Item::model()->findSumSelected($model->selected_items)
                    );

        $model->body  = $this->renderPartial('_mail_template',array('params'=>$params),true);
        
        if (isset($_POST['SendMailForm'])) 
        {
            $model->attributes = $_POST['SendMailForm'];
            
            $tmpName = $_FILES['SendMailForm']['tmp_name']['attach_files'];
            $fileName = $_FILES['SendMailForm']['name']['attach_files'];
            
            if($model->validate())
            {                 
                if(is_string($model->selected_items))
                {
                    $model->selected_items = explode (", ", $model->selected_items);
                }                
                
                $message   = new YiiMailMessage;
                $params =   array(
                    'date' => date('d M Y'),
                    'amount'=> Item::model()->findSumSelected($model->selected_items),                                
                );

                $message = EmailHistory::messageSetToCC($model->to,$model->cc,$message);      //Adding to/cc with the mail                       
                $message->subject    = $model->subject;
                $message->message->setBody($model->body, 'text/html'); // Used to attach HTML message to the body.
                $message->from = $model->from;

                if(isset($fileName) && count($fileName > 0))
                {                    
                    $folderName = SendMailForm::uploadFiles($fileName,$tmpName);
                    
                    if(!$folderName) 
                    {                         
                        throw new CHttpException(400, 'Error::File uploading failed.');     
                        yii::app()->end();
                    }
                    $message = SendMailForm::attachFiles($folderName,$message);    //Attach the the uploaded files with the mail
                }
                //Attach Items PDF only if option selected in the view
                if($model->attach_pdf==1)
                {
                    $content_PDF = $this->generatePdf($model->selected_items);
                    $message->attach(Swift_Attachment::newInstance($content_PDF, 'list.pdf', 'application/pdf'));
                } 
                //Attach Items PDF only if option selected in the view
                if($model->attach_customer_statement==1)
                {
                    $message->attach(Swift_Attachment::fromPath(yii::app()->params['customerStatement']));
                }
                
                if(!Yii::app()->mail->send($message)) //Sending Mail
                {                         
                    throw new CHttpException(400, 'Error::Sending Mail Failed.');     
                    yii::app()->end();
                }
                
                if(!EmailHistory::model()->saveHistory($folderName,$model)) //Saving to EmailHistory
                {                         
                    throw new CHttpException(400, 'Error::Saving History Failed.');     
                    yii::app()->end();
                }
                
                $item = new Item('search');
                $item->unsetAttributes();
                $item->id = $model->selected_items;                
                $dataProvider = $item->search();
                $dataProvider->pagination = false;
                echo $this->renderPartial('_mail_preview', array('dataProvider' => $dataProvider));
                yii::app()->end();
            }
        }
        
        $model->selected_items = is_array($model->selected_items) ? implode (", ", $model->selected_items) : $model->selected_items;
        
        $this->render('sendmail', array('model' => $model));
    }    
    
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 03-02-2015
    * Time :04:44 PM
    * Function to send Email History
    * @param $model EmailHistory
    * @return string
    */
    
    public function actionReminder() 
    {        
        $model = new EmailHistory('reminder');
        
        $emailHistory  = new EmailHistory('search');
        $emailHistory->unsetAttributes();
        $emailHistory->user_id = yii::app()->user->id;  
        
        if($_POST['EmailHistory_id'] && !empty($_POST['EmailHistory_id']))
        {
            $emailHistory->id = $_POST['EmailHistory_id'];            
            $history  = $emailHistory->search();
            foreach($history->getData() as $email)
              {  
                  $message   = new YiiMailMessage;
                  $message->subject    = "Reminder: ".$email->subject;  
                  $message->from = $email->from;
                  $message->message->setBody($email->body, 'text/html'); // Used to attach HTML message to the body.
                  $message = EmailHistory::messageSetToCC($email->to,$email->cc,$message);
                  $email->item_ids = (!is_array($email->item_ids )) ? explode (", ",  $email->item_ids) :  $email->item_ids; 
                  //Attach Items PDF only if option selected in the view
                  if($email->attach_pdf==1)
                  {
                      $content_PDF = $this->generatePdf($email->item_ids);
                      $message->attach(Swift_Attachment::newInstance($content_PDF, 'list.pdf', 'application/pdf'));
                  }

                  //Attach Items PDF only if option selected in the view
                  if($email->attach_customer_statement==1)
                  {
                      $message->attach(Swift_Attachment::fromPath(yii::app()->params['customerStatement']));
                  }

                if($email->attach_files != NULL)
                {
                   $message = SendMailForm::attachFiles($email->attach_files,$message);

                }
                Yii::app()->mail->send($message);
              }
              echo "Sending Reminder Complete..!";             
            yii::app()->end();
        }
        $this->render('reminder', 
                array(
                    'dataProvider' => $emailHistory->search(),
                    'model' => $model
                    ));
        yii::app()->end();
    }
      
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 03-02-2015
    * Time :04:44 PM
    * Function to generate PDF
    * @param $selectedItems EmailHistory
    * @return string
    */
    
    public function generatePdf($selectedItems)
    {
        $html2pdf = Yii::app()->ePdf->HTML2PDF(); 
        $mailContent = $this->renderPartial('_mail_pdf',array('selectedItems'=>$selectedItems),true); 
        $html2pdf->WriteHTML($mailContent);       
        $content_PDF = $html2pdf->Output('list.pdf', EYiiPdf::OUTPUT_TO_STRING);  
        return $content_PDF;
    }
    
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 03-02-2015
    * Time :04:44 PM
    * Debug Code -- Used only for Testing purpose, Need to delete before final launch
    */
    
    public function actionPdf()
    {
        //This function is only for PDF testing purpose.        
        $selectedItems = array(89,80,121);         
        $html2pdf = Yii::app()->ePdf->HTML2PDF(); 
        $mailContent = $this->renderPartial('_mail_pdf',array('selectedItems'=>$selectedItems),true); 
        $html2pdf->WriteHTML($mailContent);       
        $content_PDF = $html2pdf->Output('list.pdf', EYiiPdf::OUTPUT_TO_BROWSER);  
    }
}
