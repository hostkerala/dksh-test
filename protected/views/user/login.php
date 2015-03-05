<div class="form-holder">
	<h3>Member Login</h3>
	<p class="subtitle">Lorem Ipsum is simply dummy</p>
	<?php
	/* @var $form CActiveForm */
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'login-form',
		'htmlOptions' => array(
			'onsubmit' => 'js:popup_form_submit(this);return false;',
		),
	));
	?>
		<fieldset>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'username'); ?> 
				<?php echo $form->textField($model, 'username', array('required' => true, 'placeholder' => 'Enter email')); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'password'); ?> 
				<?php echo $form->passwordField($model, 'password', array('required' => true, 'placeholder' => 'Enter password')); ?>
				<?php echo $form->error($model,'password'); ?>
			</div>
			<div class="form-group">
				<a href="#">Lost password</a>
				<?php echo CHtml::submitButton('Login'); ?>
			</div>
		</fieldset>

	<?php $this->endWidget(); ?>
</div>
