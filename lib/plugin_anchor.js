function add_plugin_anchor(plugin,sub_plugins){
    if(plugin != null){
        var sub_plugin_HTML="";
        var nb_sub_plugin=0;
        var plugin_instance_HTML="";
        var plugin_instance="";

        for(sub_plugin_name in sub_plugins) {
            plugin_instance_HTML="";
            for(plugin_instance_key in sub_plugins[sub_plugin_name]) {
                plugin_instance=sub_plugins[sub_plugin_name][plugin_instance_key];
                plugin_instance_HTML+='<li role="anchor"><a role="sub_plugin" tabindex="-1" href="#'+plugin_instance.replace(/\s/g,"%20")+'">'+plugin_instance+'</a></li>';
            }

            if(plugin_instance_HTML=="") {
                sub_plugin_HTML+='<li role="anchor"><a role="sub_plugin" tabindex="-1" href="#'+sub_plugin_name.replace(/\s/g,"%20")+'">'+sub_plugin_name+'</a></li>';
            } else {
                if(nb_sub_plugin>0) sub_plugin_HTML+='<li role="anchor" class="divider"></li>'; 
                sub_plugin_HTML+='<li role="anchor" class="dropdown-header">'+sub_plugin_name+'</li>'+plugin_instance_HTML;
                
            }

            nb_sub_plugin++;
        }

        // If a plugin have a subelement with add a dropdown anchor
        if(sub_plugin_HTML!=""){
            $('div#bs-navbar-collapse-plugin').append('<ul class="nav navbar-nav"><li class="dropdown"><a href="#" class="dropdown-toggle" id="dropdown_anchor_'+plugin+'" data-toggle="dropdown">'+plugin+'<span class="caret"></span></a><ul class="dropdown-menu" role="menu" aria-labelledby="dropdown_anchor_'+plugin+'">'+sub_plugin_HTML+'</ul></li></ul>');
        // Else a normal anchor
        } else {
            $('div#bs-navbar-collapse-plugin').append('<ul id="plugin_bar" class="nav navbar-nav"><li><a href="#' + plugin.replace(/\s/g,"%20") + '">' +plugin+ '</a></li></ul>');
        }
    }
}


$(function() {
    var current_plugin=null;
    var current_sub_plugin_name="";
    var current_sub_plugin=[];
    $('div#dashboard h2, div#dashboard h3, div#dashboard h4').each(function() {
        $(this).prepend('<a name="' + $(this).text() + '"></a>');
        switch($(this)[0].tagName){
            case 'H2' : // Before going to next plugin, displaying the current plugin anchor
                        add_plugin_anchor(current_plugin,current_sub_plugin);
                        // Reset all var
                        current_plugin=$(this).text();
                        current_sub_plugin_name="";
                        current_sub_plugin=new Array();
                        break;
            case 'H3' : current_sub_plugin_name=$(this).text();
                        current_sub_plugin[current_sub_plugin_name]=[];
                        break;
            case 'H4' : current_sub_plugin[current_sub_plugin_name].push($(this).text());
                        break;
        }
    });
    add_plugin_anchor(current_plugin,current_sub_plugin);
});

$(function() {
    $('div#project_plugin .nav a').on('click', function(){ 
        if($('div#project_plugin button.navbar-toggle').css('display') != 'none'){
            $("div#project_plugin button.navbar-toggle").trigger( "click" );
        }
    });
});

