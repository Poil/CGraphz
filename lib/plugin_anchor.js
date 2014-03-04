$(function() {
    $('<div id="div_plugin_bar"/>').insertBefore('div#content');

    $("div#content h2").each(function() {
        $(this).prepend('<a name="' + $(this).text() + '"></a>');
        $('div#div_plugin_bar').append('<span><a href="#' + $(this).text() + '">' +  $(this).text() + '</a></span>');
    });
});
