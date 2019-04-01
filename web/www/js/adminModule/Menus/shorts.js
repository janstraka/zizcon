(function ($, window, document) {
    $(function () {

        appendFirstMeal();

    });

    // fiksme refactor x2
    var appendFirstMeal = function(){

        $('.add-meal').click(function(){
            var $meals = $('.add-meal').parents('.inputBasicInfo').find('.meals');
            console.log($meals.find('.meal').last());
            $new_meals = $meals.find('.meal').last().clone();

            var name = $new_meals.find('input').attr('name');
            // meals[1][name_cs]"
            var id = name.match(/[^[\]]+(?=])/g);
            // Array [ "1", "name_cs" ]
            var new_id = parseInt(id[0]) + 1;

            $new_meals.find('input, select').each(function(){
                $(this).val('');

                var name = $(this).attr('name');
                var name_replaced = name.replace(/\[meals\]\[.*?\]/, '[meals][' + new_id + ']');
                $(this).attr('name', name_replaced);
            });

            $meals.append($new_meals);
            //$('#day_0_meal_0').clone().appendTo('.mealsDay_0');
        });
    };




}(window.jQuery, window, document));
