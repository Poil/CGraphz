$(function() {

$('<ul id="plugin_bar" class="nav nav-pills navbar-fixed-top" style="margin-top:100px">').insertBefore('div#dashboard');

    $("div#dashboard h2").each(function() {
        $(this).prepend('<a name="' + $(this).text() + '"></a>');
        $('ul#plugin_bar').append('<li><a href="#' + $(this).text() + '">' +  $(this).text() + '</a></li>');
    });
    $('ul#plugin_bar').append('</ul>');
});

