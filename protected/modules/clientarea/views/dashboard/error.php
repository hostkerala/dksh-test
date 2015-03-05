<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<div class="content">
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	
<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
	
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</div>
</div>