(function ($, window, document) {
    $(function () {
        hidingFlashMessages();
        hidingFlashMessageByClick();
        preventDoubleSubmission();


    });


    var preventDoubleSubmission = function(){
        $('.prevent_double_submission').preventDoubleSubmission();
    };


    var hidingFlashMessages = function () {

        setTimeout(function () {
            $('.flash').css('top', '-400px');
        }, 1000);
    };

    var hidingFlashMessageByClick = function () {

        $('#hidecross').click(function () {
            $('.flash').hide("slow")
        });
    };


}(window.jQuery, window, document));

// jQuery plugin to prevent double submission of forms
jQuery.fn.preventDoubleSubmission = function() {
    $(this).on('submit',function(e){
        var $form = $(this);

        if (Nette.validateForm(this)) {
            if ($form.data('submitted') === true) {
                // Previously submitted - don't submit again
                e.preventDefault();
            } else {
                $form.data('submitted', true);
                $form.find("input[type='submit']").addClass("disabled");

                // odblokovat odeslani
                setTimeout(function(){
                    $form.data('submitted', false);
                    $form.find("input[type='submit']").removeClass("disabled");
                }, 3500);
            }
        }
    });

    // Keep chainability
    return this;
};










