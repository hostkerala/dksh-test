<?php
/* @var $this ItemController */
/* @var $categories_tree Category[] */

// prepare model for search
$item = new Item('search');
$item->unsetAttributes();
foreach($categories_tree as $category)
{
	// skip root level
	if( $category->nested_level == 0 ) continue;
	
	// print nav breadcrumb
	$this->renderPartial('_category_breadcrumb', array('category' => $category));

	// run search and run grid view widget
	$item->item_category_id = $category->id;
	$this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'grid_view'.$category->id,
		'ajaxUpdate' => 'grid_view'.$category->id,
		'afterAjaxUpdate' => 'grid_view_init_custom_forms',
		'dataProvider' => $item->search(),
		'itemsCssClass' => 'table table-hover table-bordered',
		'columns' => array(
			'id' => array(
				'name' => 'id',
				'type' => 'raw',
				'header' => Html::checkBox('select_all_'.$category->id, false, array('value' => true, 'name' => 'select_all')),
				'sortable' => false,
				'filter' => false,
				'value' => function($item){
					return Html::checkBox('item_id[]', false, array('value' => $item->id, 'name' => 'item_id_'.$item->id));
				},
				'htmlOptions' => array(
					'width' => '45px',
				),
			),
			'item_name',
			'item_create_time' => array(
				'name' => 'item_create_time',
				'type' => 'date',
				'htmlOptions' => array( 'width' => '120px' ),
			),
			'item_submit_time' => array(
				'name' => 'item_submit_time',
				'type' => 'date',
				'htmlOptions' => array( 'width' => '120px' ),
			),
			'item_amount' => array(
				'name' => 'item_amount',
				'htmlOptions' => array( 'width' => '80px' ),
			),
			'item_amount_left' => array(
				'name' => 'item_amount_left',
				'value' => function($data) {
					return $data->item_category_id == Category::ID_SUB_IN_1_2 ? '-' : $data->item_amount_left;
				},
				'htmlOptions' => array( 'width' => '120px' ),
			),
			'item_total' => array(
				'name' => 'item_total',
				'htmlOptions' => array( 'width' => '80px' ),
			),
			'typeAlias' => array(
				'name' => 'type',
				'value' => '$data->typeAlias',
				'htmlOptions' => array( 'width' => '200px' ),
			),
		),
	));
}

?>
<script>
	function grid_view_init_custom_forms(id, data){
		init_custom_forms( $('#'+id) );
	}

	$('div.grid-view th input:checkbox').change(function(){
		var needed_status = $(this).attr('checked');
		$(this).parents('table').find('td input:checkbox').each(function(i, input){
			if( $(input).attr('checked') != needed_status ){
				input._replaced.click();
				console.log('need to change')
				$(input).change();
			}
		})
	})
</script>