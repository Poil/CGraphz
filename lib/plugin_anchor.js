$(function() {
    $('div#navigation').append('<nav style="margin-bottom:0px;" class="navbar navbar-default" role="navigation"><div class="navbar-inner"><ul class="nav nav-pills" id="ul_plugin_bar"></ul></div></nav>');
	
    $("div#content h2").each(function() {
        $(this).prepend('<a name="' + $(this).text() + '"></a>');
        $('ul#ul_plugin_bar').append('<li><a href="#' + $(this).text() + '">' +  $(this).text() + '</a></li>');
    });
	$('ul#ul_plugin_bar').append('<div class="input-group pull-right" style="width : 50px; height : 48px;"><span class="input-group-addon"><input id="filtreClient"type="checkbox"></span><span class="input-group-addon" style="width:65px;">Filtre client</span></div><script type="text/javascript">$("#filtreClient").change(function(){if($("#filtreClient").is(":checked")){alert("checked");}else{alert("not checked");}});</script>');
});
