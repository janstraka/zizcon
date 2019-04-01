(function($, window, document) {

    /////////////////////////// Inits
    $categories = $('#categories ul');

    /*$form = $('form');
    $form.append('<input type="hidden" name="categories_hidden[1]">');*/


    /////////////////////////// Bindings
    $categories.on('click', '.delete', function(e){
        $(this).parents('li').remove();
    });


    $('#frm-productForm-categories_search').autoComplete({
        minChars: 0,
        source: function(term, suggest){
            term = term.toLowerCase();
            var choices = {1: 'ActionScript', 2: 'AppleScript', 3: 'Asp'}
            var matches = [];
            $.each(choices, function(id, choice){
                if (~choice.toLowerCase().indexOf(term)) {
                    matches.push([id, choice]);
                }
            });
            suggest(matches);
        },
        renderItem: function (item, search){
            return '<div class="autocomplete-suggestion" data-id="' + item[0] + '" data-title="' + item[1] + '">' + item[1] + '</div>';
        },
        onSelect: function(e, term, item){
            addCategory(item.data('id'), item.data('title'));
            /*alert('Item "' + item.data('langname') + ' ('+ item.data('lang') + ')" selected by ' +
                (e.type == 'keydown' ? 'pressing enter' : 'mouse click') + '.');*/
        }
    });


    // Functions
    function addCategory(id, title){
        var input_name = 'name="categories_hidden[' + id + ']"',
            input_selector = '[' + input_name + ']',
            category_found = $categories.find(input_selector);

        if(category_found.length === 0){
            var html = '<li><input type="hidden" ' + input_name + '><a class="delete">[x]</a> ' + title + '</li>';
            $categories.append(html);
        }
    }


}(window.jQuery, window, document));