/**
 * Types:
 * text
 * longtext
 * wysiwyg
 * email
 * number
 * zip
 * phone
 * password
 * date
 */
var formTesterFill = function (names) {
    var random = Math.floor((Math.random() * 14) + 10);
    var random_unique = Math.floor((Math.random() * 1000000) + 1);

    $.each(names, function (name, type) {
        var $input = $('[name="' + name + '"]');

        if (type == 'text') {
            $input.val(name + ' ' + random);
        } else if (type == 'longtext') {
            $input.val(name + ' lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sagittis vulputate congue. Donec tincidunt vestibulum lobortis. Ut vel velit lobortis, tincidunt ipsum id, blandit erat. Ut at pretium elit. Quisque eget quam nisi. Aliquam in tortor odio. Nunc venenatis odio nec mi pharetra, sit amet laoreet orci tempor. Aliquam laoreet augue elementum, posuere neque vel, lobortis dolor. Curabitur tincidunt venenatis odio, vitae hendrerit sem condimentum non. Nam consequat venenatis magna vel commodo. Nam dignissim laoreet finibus. Sed commodo scelerisque tellus in mollis. Fusce id sodales felis, in vestibulum odio.');
        } else if (type == 'wysiwyg'){
            var $el = document.getElementsByClassName(name)[0].id;
            tinymce.get($el).setContent('<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>');
        } else if (type == 'email') {
            $input.val(name + random_unique + '@' + 'email.cz');
        } else if (type == 'number') {
            $input.val(random);
        } else if (type == 'zip') {
            $input.val('12345');
        } else if (type == 'phone') {
            $input.val('774123456');
        } else if (type == 'date') {
            $input.val(generateFutureDate());
        }else if (type == 'datetime'){
            $input.val(generateFutureDateTime());
        } else if (type == 'password') {
            $input.val('test1');
        } else if (type == 'checkbox') {
            $input.prop('checked', true);
        } else if (type == 'radio') {
            $input.first().prop('checked', true);
        } else if (type == 'click') {
            $input.click();
        }
    });

    return false;
};

var formTesterFillSend = function (names, form_name) {
    form_name = form_name || '';

    formTesterFill(names);


    if(form_name){
        form_name = '#frm-' + form_name + '-' + form_name + ' '; // fiksme docasne reseni
    }

    $(form_name + '[name="save"]')[0].click();
};

var generateFutureDate = function(){
    var targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + 10);

    // So you can see the date we have created
    //alert(targetDate);

    var dd = targetDate.getDate();
    var mm = targetDate.getMonth() + 1; // 0 is January, so we must add 1
    var yyyy = targetDate.getFullYear();

    var dateString = dd + "." + mm + "." + yyyy;

    // So you can see the output
    //alert(dateString);

    return dateString;
};

var generateFutureDateTime = function(){
    var targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + 10);

    // So you can see the date we have created
    //alert(targetDate);

    var dd = '0' + targetDate.getDate();
        dd = dd.substr(-2);
    var mm = targetDate.getMonth() + 1; // 0 is January, so we must add 1
        mm = '0' + mm;
        mm = mm.substr(-2);
    var yyyy = targetDate.getFullYear();
    var hh = '0' + targetDate.getHours();
        hh= hh.substr(-2);
    var min = '0' + targetDate.getMinutes();
        min = min.substr(-2);
    var ss = '0' + targetDate.setSeconds();
        ss = ss.substr(-2);



    var dateString = dd + "." + mm + "." + yyyy + " " + hh + ":" + min;

    // So you can see the output
    //alert(dateString);

    return dateString;
};

var removeClassName = function(elem, name){
    var remClass = elem.className;
    var re = new RegExp('(^| )' + name + '( |$)');
    remClass = remClass.replace(re, '$1');
    remClass = remClass.replace(/ $/, '');
    elem.className = remClass;
}

