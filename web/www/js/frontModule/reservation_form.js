(function ($, window, document) {

    $(function () {

        appendFirstMeal();

    });

    var appendFirstMeal = function () {

        $('input[type=radio][name=ticket_price]').change(function () {
            // ticket_value = ($(this).val());
            refreshPrice();
        });

        $(".quantity").bind('click keyup', function () {
            refreshPrice();
        });

    };

    //   foo = $parentLabel.parent().prop('className');

    function refreshPrice() {
        var $price = $('input[name=ticket_price]:checked');
        var $ticket_count = $('input[name=quantity]');

        var $parentLabel = $price.parent();
        var $foo = $parentLabel.parent();

        if ($foo.hasClass("col-md-4 cash")) {
            // nutno vypocitat platbu predem
            var $group = $foo.closest('.form-group');
            var stay_price = $group.find('input[type=radio]').filter(':visible:first').val();

            var total_price = $price.val() * $ticket_count.val();
            var total_price_stay = stay_price * $ticket_count.val();
            $('#recalculate').html('<b>' + total_price + '</b>,- (při platbě předem: <b>'+ total_price_stay+'</b>,-)');

        } else {
            var total_price = $price.val() * $ticket_count.val();
            $('#recalculate').html('<b>' + total_price + '</b>,-');

        }

    };


}(window.jQuery, window, document));
