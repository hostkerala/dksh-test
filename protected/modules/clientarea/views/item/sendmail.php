<?php
/**
* Created By Roopan v v <yiioverflow@gmail.com>
* Date : 20-01-2015
* Time :03:19 AM
* Function get the sum of amount of selected items
* @var $form CactiveForm
* @var $model CformModel
* @var $this ItemController
*/  
?>

<div class="add-form">
    <div class="form-title">
        <h3>Email To KOSTKA </h3>
    </div>
    <br />
    <?php
        /* @var $form ClientActiveForm */
        $form = $this->beginWidget('application.modules.clientarea.widgets.ClientActiveForm', array(
            'id' => 'sendmail-form', 
             'htmlOptions' => array('enctype' => 'multipart/form-data'), 
            'isAjax' => true,
            'ajaxTarget' => '#item-content',
        ));

        $this->renderPartial('_send_email', array(
                'form' => $form,
                'model' => $model,
        )); 

        $this->endWidget(); 
    ?>
</div>