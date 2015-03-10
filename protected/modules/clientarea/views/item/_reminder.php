 <div class="alert alert-info" style="display:none" id="loading-indicator" >Sending Reminder. Please wait...</div>
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

<style>
#loading-indicator 
{
    display: none;
    width:300px;
    height: 50px;
    position: fixed;
    top: 50%;
    left: 50%;
    text-align:center;
    padding:10px;
    font:normal 16px Tahoma, Geneva, sans-serif;
    margin-left: -50px;
    margin-top: -50px;
    z-index:2;
    overflow: auto;
} 
</style>

<script>
    $(document).ajaxSend(function(event, request, settings) {
      $('#loading-indicator').show();
    });

    $(document).ajaxComplete(function(event, request, settings) {
      $('#loading-indicator').hide();
    });
    
</script>  