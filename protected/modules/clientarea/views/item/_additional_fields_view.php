<table class="additional-table table table-bordered al-c">
    <thead>
        <tr>
            <th class="text-center">Nr</th>
            <th class="text-center">Name</th>
            <th class="text-center">Yii</th>
            <th class="text-center">Unit</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Netto1</th>
            <th class="text-center">Rate</th>
            <th class="text-center">Netto2</th>
            <th class="text-center">Total</th>
        </tr>
    </thead>
    <tbody>
<?php if(!empty($additional_data)): ?>
    <?php $n = 1; foreach($additional_data as $row): ?>
        <tr>
            <td class="text-center"><?= $n ?></td>
            <td><?= $row['name']; ?></td>
            <td><?= $row['yii']; ?></td>
            <td><?= $row['unit']; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td><?= $row['netto1']; ?></td>
            <td><?= $row['rate']; ?></td>
            <td><?= $row['netto2']; ?></td>
            <td><?= $row['total']; ?></td>
        </tr>
    <?php $n += 1; endforeach; ?>
<?php endif; ?>
    </tbody>
</table>
