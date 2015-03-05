<?php
/* @var $this ItemController */
/* @var $model Item */
/* @var $client Client */
/* @var $category Category */
/* @var string $form_file */
/* @var string $related_mode */


?>
<?php if($related_mode): ?>
    <?php foreach($relatedCategoriesModels as $cat): ?>
        <?php $this->renderPartial('_category_breadcrumb', array('category' => $cat)) ?>
        <?php $this->renderPartial('_create_grid', array(
            'category' => $cat,
            'current_category' => $category,
        )) ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(!$related_mode || ($related_mode && Yii::app()->request->getQuery('item_id', false))): ?>
<div class="add-form">
    <div class="form-title">
        <h3>Add Item to <?php echo Html::encode($category->category_title); ?></h3>
    </div>

    <?php
    /* @var $form ClientActiveForm */
    $form = $this->beginWidget('application.modules.clientarea.widgets.ClientActiveForm', array(
        'id' => 'add-item-form',
        //'isAjax' => true,
        'ajaxTarget' => '#item-content',
    ));
    ?>

    <?php $this->renderPartial($form_file, array(
        'form' => $form,
        'model' => $model,
        'client' => $client,
        'controls' => true,
        'additional_data' => $additional_data,
        'rich_text_data' => $rich_text_data,
        'category' => $category
    )); ?>
    <?php $this->endWidget(); ?>
</div>
<?php endif; ?>