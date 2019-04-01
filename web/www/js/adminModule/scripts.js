(function ($, window, document) {

    $(function () {
        sidebarToogle();
        formsRenderBootstrap();
        widthOfTdOrderList();
        bindResponsiveMenuButton();
        bindConfirmDialogWhenDeleting();
        bindWysiwyg();
        bindDateTimePicker();
    });


    var sidebarToogle = function () {

        var toggleMenuBtn =   $('.btn-sidebar-hidden');



        $(toggleMenuBtn).click(function () {

            $(toggleMenuBtn).toggleClass('btn-turned');
            $('#sidebar-menu').toggleClass('sidebar-collapse');
            $('.admin-content').toggleClass('navbar-hidden');
            $('.nav-text').toggleClass('visible-xs');
            $('.navbar-nav').find('a').toggleClass('icons-nav-collapsed');
        });


        $('.collapsed').click(function () {
            $('#sidebar-menu').removeClass('sidebar-collapse');
            $('.admin-content').removeClass('navbar-hidden');
            $('.nav-text').removeClass('visible-xs');
            $('.navbar-nav').find('a').removeClass('icons-nav-collapsed');

        });
    };


    var formsRenderBootstrap = function () {

        /*$('.btn-file').prev('label').hide();*/

        setTimeout(function () {
        $("<span class='input-group-btn'>" +
            "<span class='btn-choose-file btn btn-default btn-file'>Vyberte fotografii</span>" +
            "<span class='btn-choose-file-val form-control'></span></span>").insertAfter(".btn-file");


            $('.btn-choose-file').click(function () {
            $(this).parents('.input-group-btn').prev("input[type='file']").trigger('click');
        });

            $('checkbox').find('span').click(function () {
alert('fe');
                $(this).find('label').trigger('click');
            });

        $("input[type='file']").change(function () {
            $(this).next('.input-group-btn').find('.btn-choose-file-val').text(this.value.replace(/C:\\fakepath\\/i, ''))
        });

        }, 1);
    };


    var bindDateTimePicker = function () {

        jQuery.datetimepicker.setLocale('cs');


        jQuery('.datetimepicker').datetimepicker({
            step: 10,
            format: 'd.m.Y H:i',
            onShow: function (ct, $input) {
                $(this).find('.truncate-date').data('input', $input);
            }
        });

        $('.xdsoft_today_button').after('<a href="#" class="truncate-date">[x]</a>');
        $('.truncate-date').click(function (e) {
            e.preventDefault();
            $(this).parents('.xdsoft_datetimepicker').hide();
            $(this).data('input').val('');
        });

    };

    var widthOfTdOrderList = function () {
        var CountOfAllButtons = $(' tr .td-center a.button').one().length;
        var CountOfTr = $(' tr').one().length;
        var CountOfButtons = ( CountOfAllButtons / (CountOfTr - 1) );

        console.log(CountOfAllButtons);
        console.log(CountOfTr);
        console.log(CountOfButtons);

        var f = $('.td-center').css('width', +Math.ceil(CountOfButtons) * 80);


    };


    var bindResponsiveMenuButton = function () {
        $(".menu-button").click(function () {
            $(".nav-admin").fadeToggle("fast", "linear");


        });
    };
    var bindConfirmDialogWhenDeleting = function () {
        $('.confirm').click(function (e) {
            if (!confirm('Opravdu?')) {
                e.preventDefault();
            }
        });
    };


    var bindWysiwyg = function () {
        tinyMCE.init({
            entity_encoding : "raw",
            mode: "specific_textareas",
            editor_selector: "wysiwyg",
            height: 600,
            language: 'cs',
            plugins: [
                "advlist autolink lists link image charmap preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern template"
            ],
            toolbar1: "insertfile undo redo | fontselect fontsizeselect | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | cut copy paste |  blockquote | preview | forecolor backcolor charmap template emoticons",
            image_advtab: true,
            external_filemanager_path: basePath + "/js/vendor/filemanager/",
            filemanager_title: "Filemanager",
            external_plugins: {"filemanager": basePath + "/js/vendor/filemanager/plugin.min.js"},
        });
    };

    var bindSelect2 = function () {
        $(".select2").select2();

        $(".select2-countries").select2({templateResult: formatState});
        $(".select2-statuses").select2({templateResult: formatStatus});
        $(".select2-sport").select2({templateResult: formatSport});
    };

    ///////////////////// Supportive function
    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var $state = $(
            '<span>' +
            '<p style="text-align: center; padding: 0; margin: 0;"><img src="' + basePath + '/images/flags/' + make_url(state.text) + '.png" title="' + state.text + '" /></p> ' +
                /*state.text + */' ' +
            '</span>'
        );
        return $state;
    };


    function formatStatus(status) {
        if (!status.id) {
            return status.text;
        }
        var $state = $(
            '<span>' +
            '<p style="text-align: center; padding: 0; margin: 0;"><img style="width: 18px; " src="' + basePath + '/images/statuses/' + make_url(status.text) + '.png" /></p> ' +
            '</span>'
        );
        return $state;
    };

    function formatSport(sport) {
        if (!sport.id) {
            return sport.text;
        }
        var $state = $(
            '<span>' +
            '<p style="text-align: center; padding: 0; margin: 0;"><img src="' + basePath + '/images/sports/' + make_url(sport.text) + '.png" /></p> ' +
            '</span>'
        );
        return $state;
    };


    function make_url(s) {
        var nodiac = {
            'á': 'a',
            'č': 'c',
            'ď': 'd',
            'é': 'e',
            'ě': 'e',
            'í': 'i',
            'ň': 'n',
            'ó': 'o',
            'ř': 'r',
            'š': 's',
            'ť': 't',
            'ú': 'u',
            'ů': 'u',
            'ý': 'y',
            'ž': 'z'
        };

        s = s.toLowerCase();
        var s2 = '';
        for (var i = 0; i < s.length; i++) {
            s2 += (typeof nodiac[s.charAt(i)] != 'undefined' ? nodiac[s.charAt(i)] : s.charAt(i));
        }
        return s2.replace(/[^a-z0-9_]+/g, '-').replace(/^-|-$/g, '');
    }


}(window.jQuery, window, document));