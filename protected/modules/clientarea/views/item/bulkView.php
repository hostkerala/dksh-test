<?php
/* @var $this ItemController */
/* @var $data_provider CActiveDataProvider */
?>

<div class="bulk-item-view">
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $data_provider,
	'template' => '{items}{pager}',
	'itemView'=>'_view',	
));?>

	<div class="buttons">
	<?php echo Html::link('Back to list', 
			array( ItemController::LIST_ACTION_ROUTE ), 
			array('data-target' => '#item-content', 'class' => 'btn btn-default')
		); ?>
	</div>
</div>