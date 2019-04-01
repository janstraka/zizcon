(function ($, window, document) {
    $(function () {

        appendFirstMeal();

    });

    // fiksme refactor
    var appendFirstMeal = function(){

        $('.add-meal').click(function(){
            var $meals_day = $(this).parents('.meals-day');

            console.log($meals_day.find('.meal').last());

            $new_meals = $meals_day.find('.meal').last().clone();

            var name = $new_meals.find('input').attr('name');
            var id = name.match(/[^[\]]+(?=])/g);
            var new_id = parseInt(id[2]) + 1;

            $new_meals.find('input, select').each(function(){
                $(this).val('');

                var name = $(this).attr('name');
                var name_replaced = name.replace(/\[meals\]\[.*?\]/, '[meals][' + new_id + ']');
                $(this).attr('name', name_replaced);
            });

            $meals_day.append($new_meals);
            //$('#day_0_meal_0').clone().appendTo('.mealsDay_0');
        });
    };




}(window.jQuery, window, document));
