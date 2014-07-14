$(function() {
    $('div#bs-navbar-collapse-plugin').append('<ul id="plugin_bar" class="nav nav-pills">');
    $('div#dashboard h2').each(function() {
        $(this).prepend('<a name="' + $(this).text() + '"></a>');
        $('ul#plugin_bar').append('<li class="nav-pills-no-padding"><a href="#' + $(this).text() + '">' +  $(this).text() + '</a></li>');
    });
    $('ul#bs-navbar-collapse-plugin').append('</ul>');
});
