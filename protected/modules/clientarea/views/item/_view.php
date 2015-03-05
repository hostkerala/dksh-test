<?php
/* @var $this ItemController */
/* @var $data Item */

// print nav breadcrumb
$this->renderPartial('_category_breadcrumb', array('category' => $data->category));

$this->widget('zii.widgets.CDetailView', array(
	'data' => $data,
	'htmlOptions' => array(
		'class' => 'table table-hover table-bordered',
	),
	'attributes'=>array(
		'item_name',
		'item_create_time:date',
		'item_submit_time:date',
		'item_end_time:date',
		'item_amount',
		'item_amount_left',
		'item_total',
		'typeAlias:text:' . $data->getAttributeLabel('item_type'),
	),
)); 
if(!empty($data->additional_data)){
    $this->renderPartial('_additional_fields_view', array('additional_data' => $data->additional_data));
}

?>