<?php
/* @var $this UserController */
/* @var $model User */
?>
<div class="form-holder">
	<h3>Member Registration</h3>
	<p class="subtitle">Lorem Ipsum is simply dummy</p>
	<?php 
		/* @var $form CActiveForm */
		$form = $this->beginWidget('CActiveForm', array(
			'id'=>'register-form',
		'htmlOptions' => array(
			'onsubmit' => 'js:popup_form_submit(this);return false;',
		),
	)); ?>
		<fieldset>
			<div class="form-group">
				<?php echo $form->textField($model,'user_name', array(
							'required' => true, 
							'placeholder' => 'Enter your ' . strtolower($model->getAttributeLabel('user_name')),
						)); ?> 
				<?php echo $form->error($model,'user_name'); ?>
			</div>

			<div class="form-group">
				<?php echo $form->textField($model,'user_fav_number', array(
							'required' => true, 
							'placeholder' => 'Enter your ' . strtolower($model->getAttributeLabel('user_fav_number')),
						)); ?> 
				<?php echo $form->error($model,'user_fav_number'); ?>
			</div>
			<div class="form-group">
				<?php echo $form->textField($model,'user_email', array(
							'required' => true, 
							'placeholder' => 'Enter ' . strtolower($model->getAttributeLabel('user_email')),
						)); ?> 
				<?php echo $form->error($model,'user_email'); ?>
			</div>

			<div class="form-group">
				<?php echo $form->passwordField($model,'user_password', array(
							'required' => true, 
							'placeholder' => 'Enter ' . strtolower($model->getAttributeLabel('user_password')),
						)); ?> 
				<?php echo $form->error($model,'user_password'); ?>
			</div>
			<?php if(CCaptcha::checkRequirements()): ?>
				<div class="form-group">
					<?php echo $form->labelEx($model,'verifyCode'); ?>
					<div>
					<?php $this->widget('CCaptcha', array(
						'id' => 'user_register_verify',
					)); ?>
					<?php echo $form->textField($model,'verifyCode'); ?>
					</div>
					<div class="hint">Please enter the letters as they are shown in the image above.
					<br/>Letters are not case-sensitive.</div>
					<?php echo $form->error($model,'verifyCode'); ?>
				</div>
			<?php endif; ?>
			<div class="form-group">
				<div class="checkbox-holder">
					<?php echo $form->checkBox($model, 'terms', array('required'=>true)); ?> 
					<?php echo $form->labelEx($model, 'terms'); ?> 
					<?php echo $form->error($model, 'terms'); ?>
				</div>
				<?php echo CHtml::submitButton('Sign Up'); ?>
			</div>
		</fieldset>
	<?php $this->endWidget(); ?>
</div>



