<?php
/* @var $this ItemController */
/* @var $dataProvider EmailHisstory */
$this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'grid_view',
        'ajaxUpdate' => 'grid_view',
        'afterAjaxUpdate' => 'grid_view_init_custom_forms',
        'dataProvider' => $dataProvider,
        'itemsCssClass' => 'table table-hover table-bordered',
        'columns' => array(
                'id' => array(
                        'name' => 'id',
                        'type' => 'raw',
                        'header' => Html::checkBox('EmailHistory_id'.$data->id, false, array('value' => true, 'name' => 'select_all')),
                        'sortable' => false,
                        'filter' => false,
                        'value' => function($data){
                                return Html::checkBox('EmailHistory_id[]', false, array('value' => $data->id, 'name' => 'emailHistory_id_'.$data->id));
                        },
                        'htmlOptions' => array(
                                'width' => '45px',
                        ),
                ),
                'to' => array(
                        'name' => 'to',
                        'type' => 'raw',
                ),
                'cc' => array(
                        'name' => 'cc',
                        'type' => 'raw',
                ),
                'sent_date_time' => array(
                        'name' => 'sent_date_time',
                        'type' => 'date',
                ),
        ),
));
?>

<div class="form-group">
    <div class="buttons">
        <?php   echo CHtml::submitButton('Send Reminder', array('class' => 'btn btn-primary')); ?>            
        <?php   echo Html::link('Cancel', 
                            array( ItemController::LIST_ACTION_ROUTE ), 
                            array('data-target' => '#item-content', 'class' => 'btn btn-default')
                    ); 
        ?>
    </div>
</div>