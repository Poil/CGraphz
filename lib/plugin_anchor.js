$(function() {
    //$('div#bs-navbar-collapse-plugin').append('<ul id="plugin_bar" class="nav nav-pills">');
    $('div#dashboard h2').each(function() {
        $(this).prepend('<a name="' + $(this).text() + '"></a>');
        //$('ul#plugin_bar').append('<li class="nav-pills-no-padding"><a href="#' + $(this).text() + '">' +  $(this).text() + '</a></li>');
        $('div#bs-navbar-collapse-plugin').append('<ul id="plugin_bar" class="nav navbar-nav"><li><a href="#' + $(this).text() + '">' +  $(this).text() + '</a></li></ul>');
    });
    //$('ul#bs-navbar-collapse-plugin').append('</ul>');
});

$(function() {
    $('div#project_plugin .nav a').on('click', function(){ 
        if($('div#project_plugin button.navbar-toggle').css('display') != 'none'){
            $("div#project_plugin button.navbar-toggle").trigger( "click" );
        }
    });
});

