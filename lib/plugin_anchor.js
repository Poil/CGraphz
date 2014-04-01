$(function() {
    $('div#navigation').append('<nav style="margin-bottom:0px; min-height:40px;" class="navbar navbar-default" role="navigation"><div class="navbar-inner"><ul class="nav nav-pills" id="ul_plugin_bar"></ul></div></nav>');
	
    $("div#content h2").each(function() {
        $(this).prepend('<a name="' + $(this).text() + '"></a>');
        $('ul#ul_plugin_bar').append('<li><a href="#' + $(this).text() + '">' +  $(this).text() + '</a></li>');
    });
});
