<?php
/* @var $user User */
?>
<div class="page-header">
	<div class="btn-group pull-right">
		<span><?php echo Html::encode($user->user_name); ?></span>
		<?php echo Html::link('Settings', array('/clientarea/account'), array('class' => 'btn btn-default')); ?>
		<?php echo Html::link('Log Out', array('/user/logout'), array('class' => 'btn logout btn-default')); ?>
	</div>
	<div class="logo-holder">
		<h1 class="logo"><?php echo Html::link('Dashboard', array('/clientarea')); ?></h1>
		<span>Test ASSIGNMENT</span>
	</div>
</div>