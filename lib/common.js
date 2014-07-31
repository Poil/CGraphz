$(document).ajaxStart(function () {
    $('body').addClass('wait');
}).ajaxComplete(function () { 
    $('body').removeClass('wait');
});

function resizedScreen() {
    $.post('ajax/screen_res.php', { width: $('#dashboard').width(), height: $(window).height() }, function(json) {
        if(json.outcome == 'success') {
            // do something with the knowledge possibly?
        } else {
            alert('Unable to let PHP know what the screen resolution is!');
        }
    },'json');
}
$(document).ready(resizedScreen);
$(window).resize(resizedScreen);
