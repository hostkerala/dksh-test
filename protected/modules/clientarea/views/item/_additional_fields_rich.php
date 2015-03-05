<?php
    $name = $model->id ? 'Item[' . $model->id . '][ItemRichText]' : 'Item[ItemRichText]';
?>
<?php if(!empty($additional_data)): ?>
    <?php foreach($additional_data as $item_id => $item): ?>
        <?php $n = 1; foreach($item as $id => $row): ?>
        <tr>
            <td class="text-center"><?= $n ?></td>
            <td><?= Html::textArea('Item[' . $item_id . '][ItemRichText][' . $id . '][text_message]', $row['text_message'], array('class' => 'form-control', 'required' => true)); ?></td>
            <td><?= Html::numberField('Item[' . $item_id . '][ItemRichText][' . $id . '][total]', $row['total'], array('class' => 'form-control calculator-field-total', 'required' => true, 'maxlength'=>16, 'step' => '0.01', 'min' => 0)); ?>
                <?= Html::hiddenField('Item[' . $item_id . '][ItemRichText][' . $id . '][id]', $id); ?></td>
        </tr>
        <?php endforeach; $n += 1;?>
    <?php endforeach; ?>

<?php else: ?>
    <tr>
        <td class="text-center">1</td>
        <td><?= Html::textArea($name.'[0][text_message]', '', array('class' => 'form-control', 'required' => true)); ?></td>
        <td><?= Html::numberField($name.'[0][total]', '', array('class' => 'form-control calculator-field-total', 'maxlength'=>16, 'step' => '0.01', 'min' => 0, 'required' => true)); ?></td>
    </tr>
<?php endif; ?>
    <tr>
        <td colspan="9">
            <span class="additional_row_add_button jRich btn btn-default btn-lg" data="<?=$model->id?>">Add +</span>
        </td>
    </tr>
<?php
Yii::app()->clientScript->registerScript('item_name', 'var item_name = "'.$name.'";');
Yii::app()->clientScript->registerScriptFile(Html::themeUrl() . '/assets/js/additional_rich.js?r=' . time());
Yii::app()->clientScript->registerScriptFile(Html::themeUrl() . '/assets/js/calculator.js?r=' . time());
?>
