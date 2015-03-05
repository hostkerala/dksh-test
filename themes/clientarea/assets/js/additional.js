jQuery(document).ready(function($) {
    var inputNames = [
        '',
        'name',
        'yii',
        'unit',
        'quantity',
        'netto1',
        'rate',
        'netto2',
        'total',
    ];
    var inputLengths = {
        'name': {l: 80, t: 'text', req: true},
        'yii': {l: 10, t: 'text', req: true},
        'unit': {l: 16, t: 'text', val: 'szt.', req: true},
        'quantity': {l: 11, t: 'number', val: 1, min: 0, req: true},
        'netto1': {l: 16, t: 'number', step: '0.01', cf: 'calculator-field-netto1', min: 0, req: true},
        'rate': {l: 11, t: 'number', val: 23, cf: 'calculator-field-rate', min: 0, req: true},
        'netto2': {l: 16, t: 'number', step: '0.01', cf: 'calculator-field-netto2', min: 0, req: true},
        'total': {l: 16, t: 'number', step: '0.01', cf: 'calculator-field-total', min: 0, req: true}
    };

    $(".additional_row_add_button").unbind('click');
    $(".additional_row_add_button").bind('click', function() {
        var data = $('<tr>'),
                dataCol,
                inputItem,
                trCount = $(this).closest('table').find('tr').length - 1;
        var item_name = $(this).attr('data') != '' ? 'Item[' + $(this).attr('data') + '][ItemAdditional]' : 'Item[ItemAdditional]';
        for (var i = 0; i < 9; i++) {
            dataCol = $('<td>');
            inputItem = i > 0 ? $('<input class="form-control" type="' + inputLengths[inputNames[i]].t + '"/>') : null;
            if (i > 0) {
                inputItem.attr('name', item_name + '[n_' + (trCount - 1) + '][' + inputNames[i] + ']');
                inputItem.attr('maxLength', inputLengths[inputNames[i]].l);

                if (inputLengths[inputNames[i]].step != undefined) {
                    inputItem.attr('step', inputLengths[inputNames[i]].step);
                }
                if (inputLengths[inputNames[i]].req != undefined) {
                    inputItem.prop('required', inputLengths[inputNames[i]].req);
                }
                if (inputLengths[inputNames[i]].min != undefined) {
                    inputItem.attr('min', inputLengths[inputNames[i]].min);
                }
                if (inputLengths[inputNames[i]].cf != undefined) {
                    inputItem.addClass(inputLengths[inputNames[i]].cf);
                }
                if (inputLengths[inputNames[i]].val != undefined) {
                    inputItem.val(inputLengths[inputNames[i]].val);
                }
                dataCol.html(inputItem);
            }
            else {
                dataCol.addClass('text-center');
                dataCol.text(trCount);
            }
            data.append(dataCol);
        }

        $(this).closest('tr').before(data);
    });
});
