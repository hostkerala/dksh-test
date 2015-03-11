<?php
    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.id',$selectedItems);
    $items = Item::model()->with('category', 'client', 'additional_data')->findAll($criteria);
?>    
    
<?php foreach ($items as $item): ?>
    <page orientation="paysage">
        <div class="print-preview">
            <table class="item-details" style="margin-left:750px;outline: thin solid;">
                <thead>
                    <tr>
                        <th class="border-left border-right border-top" colspan="2"><?php echo CHtml::encode($item->category->category_title) . ' ' . Yii::app()->dateFormatter->format('MM/yyyy', time()); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="show-border">
                        <td class="border-left">Create time: <?php echo Yii::app()->dateFormatter->format('yyyy-MM-dd', $item->item_create_time); ?></td>
                        <td class="border-right">Submit time: <?php echo Yii::app()->dateFormatter->format('yyyy-MM-dd', $item->item_submit_time); ?></td>
                    </tr>
                    <tr class="show-border">
                        <td class="border-left">End time: <?php echo Yii::app()->dateFormatter->format('yyyy-MM-dd', $item->item_end_time); ?></td>
                        <td class="border-right">Type: <?php echo CHtml::encode($item->typeAlias); ?></td>
                    </tr>
                </tbody>
            </table>

            <table class="client-details">
                <thead>
                    <tr>
                        <th width="50%">Sprzedawca</th>
                        <th>Nabywca</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>TESTER</td>
                        <td><?php echo CHtml::encode($item->client->client_name); ?></td>
                    </tr>
                    <tr>
                        <td>Warszawa 22/11</td>
                        <td><?php echo CHtml::encode($item->client->client_country); ?></td>
                    </tr>
                    <tr>
                        <td>11-111 Warszawa</td>
                        <td><?php echo CHtml::encode($item->client->client_postcode); ?> <?php echo CHtml::encode($item->client->client_city); ?></td>
                    </tr>
                    <tr>
                        <td>NIP: 5272525995</td>
                        <td><?php echo CHtml::encode($item->client->peselTypeAlias); ?>: <?php echo $item->client->client_pesel; ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="divider"></div>

            <table class="item-additional-fields" style="width:100%;">
                <thead>
                    <tr>
                        <th style="width:5%;">Lp</th>
                        <th style="width:10%;">Name</th>
                        <th style="width:5%;">Yii</th>
                        <th style="width:5%;">Unit</th>
                        <th style="width:10%;">Quantity</th>
                        <th style="width:5%;">Netto1</th>
                        <th style="width:5%;">Rate</th>
                        <th style="width:5%;">Netto2</th>
                        <th style="width:10%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1; ?>
                    <?php foreach($item->additional_data as $data): ?>
                        <tr class="show-border">
                            <td class="lp"><?php echo $n++; ?></td>
                            <td class="name"><?php echo CHtml::encode($data->name); ?></td>
                            <td class="yii"><?php echo CHtml::encode($data->yii); ?></td>
                            <td class="unit"><?php echo CHtml::encode($data->unit); ?></td>
                            <td class="quantity"><?php echo $data->quantity; ?></td>
                            <td class="netto1"><?php echo $data->netto1; ?></td>
                            <td class="rate"><?php echo $data->rate . '%'; ?></td>
                            <td class="netto2"><?php echo $data->netto2; ?></td>
                            <td class="total"><?php echo $data->total; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                    <br />
            <div class="clearfix">
            <table class="item-additional-fields-diff-details pull-left" style="width:50%;">
                <thead>
                    <tr class="show-border">
                        <th style="width:25%;">Rate</th>
                        <th style="width:25%;">Netto1</th>
                        <th style="width:25%;">Diff</th>
                        <th style="width:25%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sumNetto1 = 0;
                    $sumDiff = 0;
                    $sumTotal = 0;
                    ?>
                    <?php foreach($item->additional_data as $data): ?>
                        <tr class="show-border">
                            <td class="rate"><?php echo $data->rate . '%'; ?></td>
                            <td class="netto1"><?php echo $data->netto1; $sumNetto1 += $data->netto1; ?></td>
                            <td class="diff"><?php echo $diff = $data->total - $data->netto1; $sumDiff += $diff; ?></td>
                            <td class="total"><?php echo $data->total; $sumTotal += $data->total; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="show-border">
                        <td>Total sum</td>
                        <td class="netto1"><?php echo $sumNetto1; ?></td>
                        <td class="diff"><?php echo $sumDiff; ?></td>
                        <td class="total"><?php echo $sumTotal; ?></td>
                    </tr>
                </tbody>
            </table>
            <table class="item-amount-details pull-right" style="width:30%;float:left; margin-left:750px; margin-top:-65px;z-index:-1;">
                <tbody>
                    <tr>
                        <td style="width:50%;float:left;">Amount:</td>
                        <td style="width:50%;float:left;"><?php echo $item->item_amount . ' PLN'; ?></td>
                    </tr>
                    <tr>
                        <td style="width:50%;float:left;">Amount Left:</td>
                        <td style="width:50%;float:left;"><?php echo $item->item_amount_left . ' PLN'; ?></td>
                    </tr>
                    <tr>
                        <td style="width:50%;float:left;">Total sum:</td>
                        <td style="width:50%;float:left;"><?php echo $item->item_total . ' PLN'; ?></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </page>
<?php endforeach; ?>