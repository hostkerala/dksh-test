<?php
/* @var $items Item[] */
?>

<button type="button" class="btn btn-success btn-print" style="margin-bottom: 30px" onclick="window.print()">Print</button>

<?php foreach ($items as $item): ?>
    <div class="print-preview">
        <table class="item-details">
            <thead>
                <tr>
                    <th colspan="2"><?php echo CHtml::encode($item->category->category_title) . ' ' . Yii::app()->dateFormatter->format('MM/yyyy', time()); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Create time: <?php echo Yii::app()->dateFormatter->format('yyyy-MM-dd', $item->item_create_time); ?></td>
                    <td>Submit time: <?php echo Yii::app()->dateFormatter->format('yyyy-MM-dd', $item->item_submit_time); ?></td>
                </tr>
                <tr>
                    <td>End time: <?php echo Yii::app()->dateFormatter->format('yyyy-MM-dd', $item->item_end_time); ?></td>
                    <td>Type: <?php echo CHtml::encode($item->typeAlias); ?></td>
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

        <table class="item-additional-fields">
            <thead>
                <tr>
                    <th>Lp</th>
                    <th>Name</th>
                    <th>Yii</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Netto1</th>
                    <th>Rate</th>
                    <th>Netto2</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 1; ?>
                <?php foreach($item->additional_data as $data): ?>
                    <tr>
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

        <div class="clearfix">
        <table class="item-additional-fields-diff-details pull-left">
            <thead>
                <tr>
                    <th>Rate</th>
                    <th>Netto1</th>
                    <th>Diff</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sumNetto1 = 0;
                $sumDiff = 0;
                $sumTotal = 0;
                ?>
                <?php foreach($item->additional_data as $data): ?>
                    <tr>
                        <td class="rate"><?php echo $data->rate . '%'; ?></td>
                        <td class="netto1"><?php echo $data->netto1; $sumNetto1 += $data->netto1; ?></td>
                        <td class="diff"><?php echo $diff = $data->total - $data->netto1; $sumDiff += $diff; ?></td>
                        <td class="total"><?php echo $data->total; $sumTotal += $data->total; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td>Total sum</td>
                    <td class="netto1"><?php echo $sumNetto1; ?></td>
                    <td class="diff"><?php echo $sumDiff; ?></td>
                    <td class="total"><?php echo $sumTotal; ?></td>
                </tr>
            </tbody>
        </table>

        <table class="item-amount-details pull-right">
            <tbody>
                <tr>
                    <td>Amount:</td>
                    <td><?php echo $item->item_amount . ' PLN'; ?></td>
                </tr>
                <tr>
                    <td>Amount Left:</td>
                    <td><?php echo $item->item_amount_left . ' PLN'; ?></td>
                </tr>
                <tr>
                    <td>Total sum:</td>
                    <td><?php echo $item->item_total . ' PLN'; ?></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
<?php endforeach; ?>
