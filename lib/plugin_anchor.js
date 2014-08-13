function add_plugin_anchor(plugin,sp_arr){
    if(plugin != null){
        var sp_HTML="";
        var nb_sp=0;
        var pi_HTML="";
        var pi="";

        for(sp_key in sp_arr) {
            pi_HTML="";

            for(pi_key in sp_arr[sp_key]) {
                pi_name=sp_arr[sp_key][pi_key]['name'];
                pi_anchor=sp_arr[sp_key][pi_key]['anchor'].replace(/\s/g,"%20");
                pi_HTML+='<li role="anchor"><a role="sp" tabindex="-1" href="#'+pi_anchor+'">'+pi_name+'</a></li>';
            }

            if(pi_HTML=="") {
                sp_anchor=sp_arr[sp_key]['anchor'].replace(/\s/g,"%20");
                sp_HTML+='<li role="anchor"><a role="sp" tabindex="-1" href="#'+sp_anchor+'">'+sp_arr[sp_key]['name']+'</a></li>';
            } else {
                if(nb_sp>0) sp_HTML+='<li role="anchor" class="divider"></li>'; 
                sp_HTML+='<li role="anchor" class="dropdown-header">'+sp_key+'</li>'+pi_HTML;
            }

            nb_sp++;
        }

        // If a plugin have a subelement with add a dropdown anchor
        if(sp_HTML!=""){
            $('div#bs-navbar-collapse-plugin').append('<ul class="nav navbar-nav"><li class="dropdown"><a href="#" class="dropdown-toggle" id="dropdown_anchor_'+plugin+'" data-toggle="dropdown">'+plugin+'<span class="caret"></span></a><ul class="dropdown-menu" role="menu" aria-labelledby="dropdown_anchor_'+plugin+'">'+sp_HTML+'</ul></li></ul>');
        // Else a normal anchor
        } else {
            $('div#bs-navbar-collapse-plugin').append('<ul id="plugin_bar" class="nav navbar-nav"><li><a href="#' + plugin.replace(/\s/g,"%20") + '">' +plugin+ '</a></li></ul>');
        }
    }
}


$(function() {
    var cur_plugin=null;
    var cur_sp_name="";
    var cur_sp=[];
    var arr_sp={};
    $('div#dashboard h2, div#dashboard h3, div#dashboard h4').each(function() {
        switch($(this)[0].tagName){
            case 'H2' : $(this).prepend('<a name="' + $(this).text() + '"></a>');
                        // Before going to next plugin, displaying the cur plugin anchor
                        add_plugin_anchor(cur_plugin,cur_sp);
                        // Reset all var
                        arr_sp={};
                        cur_plugin=$(this).text();
                        cur_sp_name="";
                        cur_sp=new Array();
                        break;
            case 'H3' : $(this).prepend('<a name="' + $(this).text() + '"></a>');
                        cur_sp_name=$(this).text();
                        cur_sp[cur_sp_name]=[];
                        break;
            case 'H4' : $(this).prepend('<a name="' + cur_sp_name+'_'+$(this).text() + '"></a>');
                        arr_sp = { 'name': $(this).text(), 'anchor': cur_sp_name+'_'+$(this).text() };
                        cur_sp[cur_sp_name].push(arr_sp);
                        break;
        }
    });
    add_plugin_anchor(cur_plugin,cur_sp);
});

$(function() {
    $('div#project_plugin .nav a').on('click', function(){ 
        if($('div#project_plugin button.navbar-toggle').css('display') != 'none'){
            $("div#project_plugin button.navbar-toggle").trigger( "click" );
        }
    });
});

