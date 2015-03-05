<div class="col-md-12 column">
    <div class="settings-form">
		<div class="form-title">
			<h3>Settings </h3>
		</div>
		<?php
		/* @var $form CActiveForm */
		$form = $this->beginWidget('application.modules.clientarea.widgets.ClientActiveForm', array(
			'id' => 'register-form',
		));
		?>
		<div class="form-group">
			<?php echo $form->labelEx($model, 'user_fav_number'); ?> 
			<?php echo $form->numberField($model, 'user_fav_number', array('required' => true)); ?> 
			<?php echo $form->error($model, 'user_fav_number'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model, 'current_password'); ?> 
			<?php echo $form->passwordField($model, 'current_password', array('value' => '')); ?> 
			<?php echo $form->error($model, 'current_password'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model, 'new_password'); ?> 
			<?php echo $form->passwordField($model, 'new_password', array('value' => '')); ?> 
			<?php echo $form->error($model, 'new_password'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model, 'password_repeat'); ?> 
			<?php echo $form->passwordField($model, 'password_repeat', array('value' => '')); ?> 
			<?php echo $form->error($model, 'password_repeat'); ?>
		</div>

		<div class="radio">
			<?php 
				if ( !in_array($model->user_priority, User::getListPriorities()) ) 
				{
					$model->user_priority = User::PRIO_LOW;
				}
			?>
			<?php echo $form->labelEx($model, 'user_priority'); ?> 
			<div class="control-group">	
				<?php echo $form->radioButtonList($model, 'user_priority', User::getListPriorities(), array(
					'template' => '<div class="radio-holder">{input} {label}</div>',
					'separator' => '',
				)); ?>
			</div>
			<?php echo $form->error($model, 'user_priority'); ?>
		</div>

		<?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-default')); ?>
	<?php $this->endWidget(); ?>
	</div>
</div>