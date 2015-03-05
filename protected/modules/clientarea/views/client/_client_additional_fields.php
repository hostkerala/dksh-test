<?php

/* @var $this ClientController */
/* @var $model Client */
/* @var $item_id integer */

?>

<div class="client_fields">

<?php
	$names_prefix = $item_id? "Item[$item_id]" : "Item";

	/* @var $form ClientActiveForm */
	$form = $this->beginWidget('application.modules.clientarea.widgets.ClientActiveForm', array(
		'id' => 'add-item-form',
		'ajaxInlineForm' => true,
		'fieldNamesPrefix' => $names_prefix,
	));
	?>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'client_country', array('class' => 'control-label')); ?>
			<?php echo $form->textField($model, 'client_country', array('required' => true)); ?>
			<?php echo $form->error($model, 'client_country'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'client_city', array('class' => 'control-label')); ?>
			<?php echo $form->textField($model, 'client_city', array('required' => true)); ?> 
			<?php echo $form->error($model, 'client_city'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'client_street', array('class' => 'control-label')); ?>
			<?php echo $form->textField($model, 'client_street', array('required' => true)); ?> 
			<?php echo $form->error($model, 'client_street'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'client_postcode', array('class' => 'control-label')); ?>
			<?php echo $form->textField($model, 'client_postcode', array('required' => true)); ?> 
			<?php echo $form->error($model, 'client_postcode'); ?>
		</div>
        <div class="form-group">
            <div class="pull-left" style="min-width: 195px; padding-right: 14px;">
                <?php echo $form->dropDownList($model, 'client_pesel_type', Client::getPeselTypeList(), array('required' => true, 'style' => 'width: 100%')); ?>
            </div>
            <?php echo $form->textField($model, 'client_pesel', array('required' => true)); ?>
            <?php echo $form->error($model, 'client_pesel'); ?>
        </div>

<?php $this->endWidget(); ?>

</div>
