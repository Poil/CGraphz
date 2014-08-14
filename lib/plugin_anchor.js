function add_plugin_anchor(h2,cur_h3_array){
    if(h2!=null){
        var h3_HTML="";
        var nb_h3=0;
        var h4_HTML="";
        var h4="";

        for(h3_key in cur_h3_array) {
            h4_HTML="";

            for(h4_key in cur_h3_array[h3_key]) {
                h4_name=cur_h3_array[h3_key][h4_key]['name'];
                h4_anchor=cur_h3_array[h3_key][h4_key]['anchor'].replace(/\s/g,"%20");
                h4_HTML+='<li role="anchor"><a role="h4" tabindex="-1" href="#'+h4_anchor+'">'+h4_name+'</a></li>';
            }

            if(h4_HTML=="") {
                h3_anchor=h3_key.replace(/\s/g,"%20");
                h3_HTML+='<li role="anchor"><a role="h3" tabindex="-1" href="#'+h3_anchor+'">'+h3_key+'</a></li>';
            } else {
                h3_anchor=h3_key.replace(/\s/g,"%20");
                if(nb_h3>0) h3_HTML+='<li role="anchor" class="divider"></li>'; 
                h3_HTML+='<li role="anchor" class="dropdown-header"><a role="h3" tabindex="-1" href="#'+h3_anchor+'">'+h3_key+'</a></li>'+h4_HTML;
            }

            nb_h3++;
        }

        // If a plugin have a subelement we add a dropdown anchor
        if(h3_HTML!=""){
            $('div#bs-navbar-collapse-plugin').append('<ul class="nav navbar-nav"><li class="dropdown"><a href="#" class="dropdown-toggle" id="dropdown_anchor_'+h2+'" data-toggle="dropdown">'+h2+'<span class="caret"></span></a><ul class="dropdown-menu" role="menu" aria-labelledby="dropdown_anchor_'+h2+'">'+h3_HTML+'</ul></li></ul>');
        // Else a normal anchor
        } else {
            $('div#bs-navbar-collapse-plugin').append('<ul id="plugin_bar" class="nav navbar-nav"><li><a href="#' + h2.replace(/\s/g,"%20") + '">' +h2+ '</a></li></ul>');
        }
    }
}


$(function() {
    var cur_h2=null;
    var cur_h3_name="";
    var cur_h3_array=[];
    var h4_assoc={};
    $('div#dashboard h2, div#dashboard h3, div#dashboard h4').each(function() {
        switch($(this)[0].tagName){
            case 'H2' : $(this).prepend('<a name="' + $(this).text() + '"></a>');
                        // Before going to next plugin, displaying the cur plugin anchor
                        add_plugin_anchor(cur_h2,cur_h3_array);
                        // Reset all var
                        h4_assoc={};
                        cur_h2=$(this).text();
                        cur_h3_name="";
                        cur_h3_array=new Array();
                        break;
            case 'H3' : $(this).prepend('<a name="' + $(this).text() + '"></a>');
                        cur_h3_name=$(this).text();
                        cur_h3_array[cur_h3_name]=[];
                        break;
            case 'H4' : $(this).prepend('<a name="' + cur_h3_name+'_'+$(this).text() + '"></a>');
                        h4_assoc = { 'name': $(this).text(), 'anchor': cur_h3_name+'_'+$(this).text() };
                        cur_h3_array[cur_h3_name].push(h4_assoc);
                        break;
        }
    });
    add_plugin_anchor(cur_h2,cur_h3_array);
});

$(function() {
    $('div#project_plugin .nav a').on('click', function(){ 
        if($('div#project_plugin button.navbar-toggle').css('display') != 'none'){
            $("div#project_plugin button.navbar-toggle").trigger( "click" );
        }
    });
});

