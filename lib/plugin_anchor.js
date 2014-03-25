$(function() {
    //$('<div id="div_plugin_bar"/>').insertBefore('div#content');
	$('<nav class="navbar navbar-default" role="navigation"><div class="navbar-inner"><ul class="nav nav-pills" id="ul_plugin_bar"></ul></div></nav>').insertBefore('div#content');

    $("div#content h2").each(function() {
        $(this).prepend('<a name="' + $(this).text() + '"></a>');
        $('ul#ul_plugin_bar').append('<li><a href="#' + $(this).text() + '">' +  $(this).text() + '</a></li>');
    });
});
