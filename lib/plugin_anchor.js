function addAncrePlugin(plugin,sousPlugins){
	if(plugin != null){
		var sousPluginHTML="";
		var nbSousPlugin=0;
		for(sousPluginName in sousPlugins){
			var pluginInstanceHTML="";
			for(plugin_instance_key in sousPlugins[sousPluginName]){
				var plugin_instance=sousPlugins[sousPluginName][plugin_instance_key];
				pluginInstanceHTML+='<li role="ancre"><a role="sousPlugin" tabindex="-1" href="#'+plugin_instance.replace(/\s/g,"%20")+'">'+plugin_instance+'</a></li>';
			}
			 

			if(pluginInstanceHTML==""){
				sousPluginHTML+='<li role="ancre"><a role="sousPlugin" tabindex="-1" href="#'+sousPluginName.replace(/\s/g,"%20")+'">'+sousPluginName+'</a></li>';
			}else{
				if(nbSousPlugin>0) sousPluginHTML+='<li role="ancre" class="divider"></li>'; 
				sousPluginHTML+='<li role="ancre" class="dropdown-header">'+sousPluginName+'</li>'+pluginInstanceHTML;
				
			}

			nbSousPlugin++;
		}

		// Si un plugin a des sous projet on ajoute une ancre DropDown
		if(sousPluginHTML!=""){
			$('div#bs-navbar-collapse-plugin').append('<ul class="nav navbar-nav"><li class="dropdown"><a href="#" class="dropdown-toggle" id="dropDown_ancre_'+plugin+'" data-toggle="dropdown">'+plugin+'<span class="caret"></span></a><ul class="dropdown-menu" role="menu" aria-labelledby="dropDown_ancre_'+plugin+'">'+sousPluginHTML+'</ul></li></ul>');
		// Sinon on ajoute une ancre normal
		}else{
			$('div#bs-navbar-collapse-plugin').append('<ul id="plugin_bar" class="nav navbar-nav"><li><a href="#' + plugin.replace(/\s/g,"%20") + '">' +plugin+ '</a></li></ul>');
		}
	}
}


$(function() {
    var currentPlugin=null;
	var currentSousPluginName="";
	var currentSousPlugin=[];
    $('div#dashboard h2, div#dashboard h3, div#dashboard h4').each(function() {
		$(this).prepend('<a name="' + $(this).text() + '"></a>');
		switch($(this)[0].tagName){
			case 'H2' : // Avant de passer au nouveau plugin on ajout l'ancre du plugin courant
						addAncrePlugin(currentPlugin,currentSousPlugin);

						// on réinitialise les variables
						currentPlugin=$(this).text();
						currentSousPluginName="";
						currentSousPlugin=new Array();
						break;
			case 'H3' : currentSousPluginName=$(this).text();
						currentSousPlugin[currentSousPluginName]=[];
						break;
			case 'H4' : currentSousPlugin[currentSousPluginName].push($(this).text());
                        break;
		}
    });
	addAncrePlugin(currentPlugin,currentSousPlugin);
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
