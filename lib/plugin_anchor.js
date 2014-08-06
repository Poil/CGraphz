$(function() {
    $('div#dashboard h2').each(function() {
        if ($(this).text() != 'snmp') {
          $(this).prepend('<a name="' + $(this).text() + '"></a>');
          $('div#bs-navbar-collapse-plugin').append('<ul id="plugin_bar" class="nav navbar-nav"><li><a href="#' + $(this).text() + '">' +  $(this).text() + '</a></li></ul>');
        } else {
          $('div#dashboard h3',this).each(function() {
            $(this).prepend('<a name="' + $(this).text() + '"></a>');
            $('div#bs-navbar-collapse-plugin').append('<ul id="plugin_bar" class="nav navbar-nav"><li><a href="#' + $(this).text() + '">' +  $(this).text() + '</a></li></ul>');
          });
        }
    });
});

$(function() {
    $('div#project_plugin .nav a').on('click', function(){ 
        if($('div#project_plugin button.navbar-toggle').css('display') != 'none'){
            $("div#project_plugin button.navbar-toggle").trigger( "click" );
        }
    });
});

