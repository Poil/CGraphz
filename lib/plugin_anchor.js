$(function() {
    var snmp=false;
    $('div#dashboard h2, div#dashboard h3').each(function() {
        if ($(this)[0].tagName=='H2') {
          if ($(this).text().toLowerCase()=='snmp') {
            snmp=true;
          } else {
            $(this).prepend('<a name="' + $(this).text() + '"></a>');
            $('div#bs-navbar-collapse-plugin').append('<ul id="plugin_bar" class="nav navbar-nav"><li><a href="#' + $(this).text().replace(/\s/g,"%20") + '">' +  $(this).text() + '</a></li></ul>');
            snmp=false;
          }
        } else if (snmp==true) {
          $(this).prepend('<a name="' + $(this).text() + '"></a>');
          $('div#bs-navbar-collapse-plugin').append('<ul id="plugin_bar" class="nav navbar-nav"><li><a href="#' + $(this).text().replace(/\s/g,"%20") + '">snmp ' +  $(this).text() + '</a></li></ul>');
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

/*
$(function() {
    var H2 = null;
    var H3 = null;
    var navbar = null;
    $('div#dashboard h2, div#dashboard h3').each(function() {
        if ($(this)[0].tagName=='H2') {
            H2=$(this).text();
            H3=null;
            $(this).prepend('<a name="' + $(this).text() + '"></a>');
        } else if ($(this)[0].tagName=='H3') {
            H3=$(this).text();
            $(this).prepend('<a name="' + $(this).text() + '"></a>');
        }
        if (H3!='' && H2!=OLD_H2) {
            navbar='<ul class="'
        }
    });
});
*/
