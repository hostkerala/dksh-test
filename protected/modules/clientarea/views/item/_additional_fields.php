<?php
    $name = $model->id ? 'Item[' . $model->id . '][ItemAdditional]' : 'Item[ItemAdditional]';
?>
<?php if(!empty($additional_data)): ?>
    <?php foreach($additional_data as $item_id => $item): ?>
        <?php $n = 1; foreach($item as $id => $row): ?>
        <tr>
            <td class="text-center"><?= $n ?></td>
            <td><?= Html::textField('Item[' . $item_id . '][ItemAdditional][' . $id . '][name]', $row['name'], array('class' => 'form-control', 'required' => true, 'maxlength'=>80)); ?></td>
            <td><?= Html::textField('Item[' . $item_id . '][ItemAdditional][' . $id . '][yii]', $row['yii'], array('class' => 'form-control', 'required' => true, 'maxlength'=>10)); ?></td>
            <td><?= Html::textField('Item[' . $item_id . '][ItemAdditional][' . $id . '][unit]', $row['unit'], array('class' => 'form-control', 'required' => true, 'maxlength'=>16)); ?></td>
            <td><?= Html::numberField('Item[' . $item_id . '][ItemAdditional][' . $id . '][quantity]', $row['quantity'], array('class' => 'form-control', 'required' => true, 'maxlength'=>11, 'min' => 0)); ?></td>
            <td><?= Html::numberField('Item[' . $item_id . '][ItemAdditional][' . $id . '][netto1]', $row['netto1'], array('class' => 'form-control calculator-field-netto1', 'required' => true, 'maxlength'=>16, 'step' => '0.01', 'min' => 0)); ?></td>
            <td><?= Html::numberField('Item[' . $item_id . '][ItemAdditional][' . $id . '][rate]', $row['rate'], array('class' => 'form-control calculator-field-rate', 'required' => true, 'maxlength'=>11, 'min' => 0)); ?></td>
            <td><?= Html::numberField('Item[' . $item_id . '][ItemAdditional][' . $id . '][netto2]', $row['netto2'], array('class' => 'form-control calculator-field-netto2', 'required' => true, 'maxlength'=>16, 'step' => '0.01', 'min' => 0)); ?></td>
            <td><?= Html::numberField('Item[' . $item_id . '][ItemAdditional][' . $id . '][total]', $row['total'], array('class' => 'form-control calculator-field-total', 'required' => true, 'maxlength'=>16, 'step' => '0.01', 'min' => 0)); ?><?= Html::hiddenField('Item[' . $item_id . '][ItemAdditional][' . $id . '][id]', $id); ?></td>
        </tr>
        <?php endforeach; $n += 1;?>
    <?php endforeach; ?>

<?php else: ?>
    <tr>
        <td class="text-center">1</td>
        <td><?= Html::textField($name.'[0][name]', '', array('class' => 'form-control', 'maxlength'=>80, 'required' => true)); ?></td>
        <td><?= Html::textField($name.'[0][yii]', '', array('class' => 'form-control', 'maxlength'=>10, 'required' => true)); ?></td>
        <td><?= Html::textField($name.'[0][unit]', 'szt.', array('class' => 'form-control', 'maxlength'=>16, 'required' => true)); ?></td>
        <td><?= Html::numberField($name.'[0][quantity]', 1, array('class' => 'form-control', 'maxlength'=>11, 'min' => 0, 'required' => true)); ?></td>
        <td><?= Html::numberField($name.'[0][netto1]', '', array('class' => 'form-control calculator-field-netto1', 'maxlength'=>16, 'step' => '0.01', 'min' => 0, 'required' => true)); ?></td>
        <td><?= Html::numberField($name.'[0][rate]', 23, array('class' => 'form-control calculator-field-rate', 'maxlength'=>11, 'min' => 0, 'required' => true)); ?></td>
        <td><?= Html::numberField($name.'[0][netto2]', '', array('class' => 'form-control calculator-field-netto2', 'maxlength'=>16, 'step' => '0.01', 'min' => 0, 'required' => true)); ?></td>
        <td><?= Html::numberField($name.'[0][total]', '', array('class' => 'form-control calculator-field-total', 'maxlength'=>16, 'step' => '0.01', 'min' => 0, 'required' => true)); ?></td>
    </tr>
<?php endif; ?>
    <tr>
        <td colspan="9">
            <span class="additional_row_add_button btn btn-default btn-lg" data="<?=$model->id?>">Add +</span>
        </td>
    </tr>
<?php
Yii::app()->clientScript->registerScript('item_name', 'var item_name = "'.$name.'";');
Yii::app()->clientScript->registerScriptFile(Html::themeUrl() . '/assets/js/additional.js?r=' . time());
Yii::app()->clientScript->registerScriptFile(Html::themeUrl() . '/assets/js/calculator.js?r=' . time());
?>
