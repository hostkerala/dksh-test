<?php
$item_id = Yii::app()->request->getQuery('item_id', false);
if($item_id) {
    Yii::app()->clientScript->registerScript('select_active_row', "
        $('#selection_grid_view table tbody tr td:first-child:contains(".$item_id.")').parent().addClass('selected');
    ");
}
Yii::app()->clientScript->registerScript('selection_grid_view', "

    $('#selection_grid_view table tbody tr').click(function(e) {
        var link = $(this).children(':nth-child(2)').find('a').attr('href');
        ajax_load_block($('#item-content'), link);
    });
");
$item = new Item('search');
$item->unsetAttributes();
// run search and run grid view widget
$item->item_category_id = $category->id;
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'selection_grid_view',
    'ajaxUpdate' => 'grid_view'.$category->id,
    'afterAjaxUpdate' => 'grid_view_init_custom_forms',
    'dataProvider' => $item->advancedSearch($current_category),
    'itemsCssClass' => 'table table-hover table-bordered',
    'selectableRows'=>1,
    'columns' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'raw',
            'sortable' => false,
            'filter' => false,
            'htmlOptions' => array(
                'width' => '45px',
            ),
        ),
        array(
            'name' => 'item_name',
            'type' => 'raw',
            'value' => function($data) use ($current_category) {
                return CHtml::link($data->item_name,
                    array("/clientarea/item/create", "category_id" => $current_category->id, "item_id" => $data->id));
            }
        ),
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
//            'visible' => !in_array($category->id, array(Category::ID_SUB_IN_1_2, Category::ID_SUB_IN_1_3))
        ),
    ),
));
