$(document).ajaxStart(function () {
    $('body').addClass('wait');
}).ajaxComplete(function () { 
    $('body').removeClass('wait');
});
