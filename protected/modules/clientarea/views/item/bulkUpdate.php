<?php
/* @var $this ItemController */
/* @var $items Item[] */
/* @var $clients Client[] */

/* @var $form ClientActiveForm */
?>

<?php $form = $this->beginWidget('application.modules.clientarea.widgets.ClientActiveForm', array(
	'id' => 'bulk-item-form',
	'isAjax' => true,
	'ajaxTarget' => '#item-content',
	'bulkMode' => true,
)); ?>

    <?php $count = count($items); $n = 0; ?>
    <?php foreach($items as $item_id => $item): ?>
        <?php $this->renderPartial('_category_breadcrumb', array('category' => $item->category)); ?>
        <div class="add-form">
            <?php $this->renderPartial(ItemController::getFormFileNameByCategoryId($item->category), array(
                'form' => $form,
                'model' => $item,
                'client' => $clients[$item_id],
                'controls' => false,
                'additional_data' => $additional_data[$item_id],
                'rich_text_data' => $rich_text_data[$item_id],
                'category' => $item->category
            )); ?>

            <?php if($count === ++$n): ?>
                <div class="form-group buttons">
                    <?php echo Html::link('Back to list',
                        array( 'item/list', 'categoryType' => $item->category->category_type ),
                        array('data-target' => '#item-content', 'class' => 'btn btn-default')
                    ); ?>
                    <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-default')); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php $this->endWidget(); ?>
