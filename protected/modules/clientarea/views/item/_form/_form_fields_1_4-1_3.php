<?php
/* @var $this ItemController */
/* @var $model Item */
/* @var $client Client */
/* @var $form ClientActiveForm */
/* @var $controls boolean */
/* @var $category_id integer */
/* @var $category Category */
/* @var $additional_data array */

$model_id = $model->isNewRecord ? 0 : $model->id;
?>

<div class="form-wrap form-horizontal item_form_<?php echo $model_id; ?>">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?php echo $form->labelEx($model, 'item_name', array('class' => 'control-label')); ?>
                <?php echo Html::activeAutocompleteCombo($model, 'item_client_name', Client::getPairs(), array(
                    'defaultValue' => $model->item_client_id ? $model->item_client_id : $model->item_name,
                    'bulkMode' => $form->bulkMode,
                    'empty' => 'Select option or type here',
                    'onSelect' => 'js:load_client_additional_fields',
                    'comboParams' => array(
                        'client_ajax_url' => Html::url('/clientarea/client/ajaxClientAdditionalFields'),
                        'model_id' => $model_id,
                    ),
                    'htmlOptions' => array('required' => true),
                )); ?>
                <?php echo $form->error($model, 'item_client_name'); ?>
            </div>
            <?php if (empty($client)) : ?>
                <div class="form-inline client_fields" style="display: none;"></div>
            <?php else : ?>
                <?php $this->renderPartial('/client/_client_additional_fields', array('model' => $client, 'item_id' => $model_id)); ?>
            <?php endif; ?>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <?php echo $form->labelEx($model, 'item_type', array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'item_type', Item::getTypesList(), array('empty' => 'Select item type', 'required' => true)); ?>
                <?php echo $form->error($model, 'item_type'); ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'item_rebo_time', array('class' => 'control-label')); ?>
                <?php echo $form->datePickerField($model, 'item_rebo_time', array('required' => true)); ?>
                <?php echo $form->error($model, 'item_rebo_time'); ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'item_create_time', array('class' => 'control-label')); ?>
                <?php echo $form->datePickerField($model, 'item_create_time', array('required' => true)); ?>
                <?php echo $form->error($model, 'item_create_time'); ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'item_end_time', array('class' => 'control-label')); ?>
                <?php echo $form->datePickerField($model, 'item_end_time', array('required' => true)); ?>
                <?php echo $form->error($model, 'item_end_time'); ?>
            </div><div class="form-group">
                <?php echo $form->labelEx($model, 'item_seto_time', array('class' => 'control-label')); ?>
                <?php echo $form->datePickerField($model, 'item_seto_time', array('required' => true)); ?>
                <?php echo $form->error($model, 'item_seto_time'); ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'item_amount'); ?>
                <?php echo $form->numberField($model, 'item_amount', array('required' => true, 'step' => '0.01', 'class' => 'form-control')); ?>
                <?php echo $form->error($model, 'item_amount'); ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'item_amount_left'); ?>
                <?php echo $form->numberField($model, 'item_amount_left', array('required' => true, 'step' => '0.01', 'min' => 0, 'class' => 'form-control')); ?>
                <?php echo $form->error($model, 'item_amount_left'); ?>
            </div>
        </div>
    </div>
    <?php if (!empty($controls)) : ?>
        <div class="form-group buttons">
            <?php echo Html::link('Back to list',
                array('item/list', 'categoryType' => $category->category_type),
                array('data-target' => '#item-content', 'class' => 'btn btn-default')
            );
            ?>
            <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-default')); ?>
        </div>
    <?php endif; ?>
</div>
