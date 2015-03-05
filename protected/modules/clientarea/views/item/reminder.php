<?php
/**
* Created By Roopan v v <yiioverflow@gmail.com>
* Date : 03-02-2015
* Time :03:49 PM
* Reminder List
* @var $form CactiveForm
* @var $this ItemController
*/  
?>


<div class="add-form">
    <div class="form-title">
        <h3>Reminder List </h3>
    </div>
    <br />
    <?php
        /* @var $form ClientActiveForm */
        $form = $this->beginWidget('application.modules.clientarea.widgets.ClientActiveForm', array(
            'id' => 'reminder-form',
            'enableAjaxValidation'=>true,
            'isAjax' => true,
            'ajaxTarget' => '#item-content',
        ));

        $this->renderPartial('_reminder', 
                array(
                    'dataProvider' => $dataProvider,
                    'model' => $model
                    ));
        $this->endWidget(); 
    ?>
</div>