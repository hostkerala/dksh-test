jQuery(document).ready(function($) {
    function calculate_amounts($selector) {
        var $nextAmountColumn = $selector.closest('table').next('.amount-column');
        var $itemAmount = $nextAmountColumn.find('.calculator-field-item-amount');
        var $itemAmountLeft = $nextAmountColumn.find('.calculator-field-item-amount-left');
        var $itemTotal = $nextAmountColumn.find('.calculator-field-item-total');

        var itemTotal = 0;

        $selector.closest('table').find('.calculator-field-total').each(function(index, element) {
            var total = parseFloat($(element).val());
            if (total) {
                itemTotal += total;
            }
        });

        $itemTotal.val(itemTotal.toFixed(2));
        $itemAmountLeft.val((parseFloat($itemTotal.val()) - parseFloat($itemAmount.val())).toFixed(2));
    }

    $(document).on('change', '.calculator-field-rate, .calculator-field-netto1', function() {
        var $selector = $(this);
        var $closestTr = $selector.closest('tr');
        var $netto1 = $closestTr.find('.calculator-field-netto1');
        var $rate = $closestTr.find('.calculator-field-rate');
        var $netto2 = $closestTr.find('.calculator-field-netto2');
        var $total = $closestTr.find('.calculator-field-total');

        $total.val((parseFloat($netto1.val()) * (1 + parseFloat($rate.val()) / 100)).toFixed(2));
        $netto2.val(parseFloat($netto1.val()));

        calculate_amounts($total);
    });

    $(document).on('change', '.calculator-field-total', function() {
        var $total = $(this);
        var $closestTr = $total.closest('tr');
        var $netto1 = $closestTr.find('.calculator-field-netto1');
        var $rate = $closestTr.find('.calculator-field-rate');
        var $netto2 = $closestTr.find('.calculator-field-netto2');

        $netto1.val((parseFloat($total.val()) / (1 + parseFloat($rate.val()) / 100)).toFixed(2));
        $netto2.val(parseFloat($netto1.val()));

        calculate_amounts($total);
    });

    $(document).on('change', '.calculator-field-item-amount', function() {
        var $itemAmount = $(this);
        var $closest = $itemAmount.closest('.amount-column');
        var $itemAmountLeft = $closest.find('.calculator-field-item-amount-left');
        var $itemTotal = $closest.find('.calculator-field-item-total');
        $itemAmountLeft.val((parseFloat($itemTotal.val()) - parseFloat($itemAmount.val())).toFixed(2));
    });
});
