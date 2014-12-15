$(function(){
	$('#project_plugin').attr('id','compare-toolbar');
	$('#bs-navbar-collapse-plugin').attr('id','bs-navbar-collapse-compare-toolbar');	
	$('div#bs-navbar-collapse-compare-toolbar').append('<form class="navbar-form navbar-left" role="search"><div class="form-group"><input id="serverToAdd" type="text" class="form-control" placeholder="Ajouter serveur..."></div><button id="addServer" type="submit" class="btn btn-default">Ajouter serveur</button></form><div id="jquery-live-search-add-host" class="modal-content" style="display: none; position: fixed; left: 709.03125px; top: 35px; width: 182px;"></div>');

	$('#addServer').on('click',function(){
		var serverName=$('#serverToAdd').val();
		$('#serverToAdd').val('');
		if(serverName!=""){
			addHost(serverName);
		}	
		return false;	
	});
	
	jQuery('#serverToAdd').liveSearch({url: ajaxURL+'getAllServers.ajax.php'+'?f_q=', id:"jquery-live-search-add-host"});

	$('div#bs-navbar-collapse-compare-toolbar').append('<form class="navbar-form navbar-right" ><div class="form-group"><input id="filtreServeur" type="text" class="form-control" placeholder="Filtrer serveur..."/></div></form>');

    $.expr[':'].attrCaseInsensitive = function(node, stackIndex, properties){
        var args = properties[3].split(',').map(function(arg) {
            return arg.replace(/^\s*["']|["']\s*$/g, '');
        });
        return $(node).attr(args[0]).toLowerCase().indexOf(args[1]) > -1;
	};

	$('#filtreServeur').keyup(function(){
        var server=$(this).val();
		
		if(server!=""){
			$('#servers .serverName:not(:attrCaseInsensitive(value, "'+server.toLowerCase()+'"))').each(function(){
                var serverName=$(this).attr('value');
				$(this).parent().hide();

				$('#servers .imggraph[src*="?h='+serverName+'&"]').each(function(){
					$(this).parent().parent().parent().hide();
				});
            });

			$('#servers .serverName:attrCaseInsensitive(value, "'+server.toLowerCase()+'")').each(function(){
                var serverName=$(this).attr('value');
				$(this).parent().show();

				$('#servers .imggraph[src*="?h='+serverName+'&"]').each(function(){
                    $(this).parent().parent().parent().show();
                });
            });

		}else{
			$('#servers .serverName:hidden').each(function(){
				$(this).parent().show();
			});

			$('#servers .imggraph:hidden').each(function(){
                $(this).parent().parent().parent().show();
            });

		}
	
		synchroTitleWithGraph();
	});

});

function synchroTitleWithGraph(){
	$('#servers tr:hidden:has(span[lvl])').each(function(){ $(this).show()});

	var elem_suivant=null;
	$($('#servers tr:not(> th):not(:hidden)').get().reverse()).each(function(){
        var lvl="";
		if($(this).filter(':has(span[lvl])').length > 0){
            $(this).children().first().children().first().filter('span[lvl]').each(function(){
                lvl=$(this).attr('lvl');
            });
        }else{
            if($(this).children().filter(':has(figure:not(:hidden))').length > 0){
                lvl='graph';
            }
        }

        if(lvl!=""){
            if(lvl=="4"){
                if(elem_suivant=== null || elem_suivant!="graph"){
                    $(this).hide();
                }else{
                    elem_suivant=lvl;
                }
			}else if(lvl=="3"){
                if(elem_suivant=== null || (elem_suivant!="graph" && elem_suivant!="4")){
                    $(this).hide();
                }else{
                    elem_suivant=lvl;
                }
            }else if(lvl=="2"){
                if(elem_suivant=== null || (elem_suivant!="graph" && elem_suivant!="4" && elem_suivant!="3") ){
                    $(this).hide();
                }else{
                    elem_suivant=lvl;
                }
            }else{
                elem_suivant='graph';
            }
        }
    });
}


function getParameterByName(url,name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(url);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function addGraphInit(p,pc,pi,t,tc){
	var src=$('#servers .imggraph-pattron').attr('src');
    var time_start=getParameterByName(src,'s');
    var time_end=getParameterByName(src,'e');
    var timer=getParameterByName(src,'timer');

    timer_txt="";
    if(time_start!="") timer_txt+="&s="+time_start;
    if(time_end!="") timer_txt+="&e="+time_end;
    if(timer!="") timer_txt+="&timer="+timer;
    time_range={
        "s" : time_start,
        "e" : time_end,
        "timer" : timer,
        "txt" : timer_txt
    };

	showGraph(p,pc,pi,t,tc,time_range);
}

function addGraph(id){
	var obj=$('#'+id+' span');
	

	var plugin=getPlugin(obj);
	var niveau=obj.attr('niveau');	

	var src=$('#servers .imggraph-pattron').attr('src');
	var time_start=getParameterByName(src,'s');
	var time_end=getParameterByName(src,'e');
	var timer=getParameterByName(src,'timer');

	timer_txt="";
	if(time_start!="") timer_txt+="&s="+time_start;
	if(time_end!="") timer_txt+="&e="+time_end;
	if(timer!="") timer_txt+="&timer="+timer;
	time_range={
		"s" : time_start,
		"e" : time_end,
		"timer" : timer,
		"txt" : timer_txt
	};
	printGraph(niveau,plugin,time_range);
}


function printGraph(niveau,plugin,time_range){
	var p=plugin['p'];

	if(niveau=="plugin"){
		showAllGraphPC(p,time_range);	
	}else{
		var pc=plugin['pc'];

		if(niveau=="plugin-categorie"){
			showAllGraphPI(p,pc,time_range);
		}else{
		    var pi=plugin['pi'];

			if(niveau=="plugin-instance"){
				showAllGraphT(p,pc,pi,time_range);
			}else{
				var t=plugin['t'];

				showGraph(p,pc,pi,t,'',time_range);
			}
	    }
	}

}

function showAllGraphPC(p,time_range){
	var tab_pc=pluginJs[p];

    for(pc_name in tab_pc){
        showAllGraphPI(p,pc_name,time_range);
    }
}

function showAllGraphPI(p,pc,time_range){
	var tab_pi=pluginJs[p][pc];	

	for(pi_name in tab_pi){
		showAllGraphT(p,pc,pi_name,time_range);
	}
}

function showAllGraphT(p,pc,pi,time_range){
	var tab_t=pluginJs[p][pc][pi];

	for(t_name in tab_t){
		showGraph(p,pc,pi,t_name,'',time_range);
	}
}


function showGraph(p,pc,pi,t,tc,time_range){
	if(pc=="null") pc="";
	if(pi=="null") pi="";
	if(t=="null") t="";
	if(tc=="null") tc="";

	var lvl_h=2;

	var p_title="";
	var pc_title="";
	var pi_title="";

	var elem_conteneur=$('#servers tr');


	var elem_plugin=$('#servers tbody[plugin^="p='+p+'&"]');

	if(elem_plugin.length <= 0){
		p_title='<tbody plugin="p='+p+'&amp;pc=&amp;pi=&amp;t=&amp;tc=&amp;ti="><tr><td><span lvl="'+lvl_h+'" target="plugin">'+p+'</span></td><td></td></tr></tbody>';
	}else{
		elem_conteneur=elem_plugin;
	}	
	lvl_h++;

	if(pc!=""){
		var elem_pc=$('#servers tbody[plugin^="p='+p+'&pc='+pc+'&"]');
		if(elem_pc.length <= 0){
			pc_title='<tbody plugin="p='+p+'&amp;pc='+pc+'&amp;pi=&amp;t=&amp;tc=&amp;ti="><tr><td><span lvl="'+lvl_h+'" target="plugin">'+pc+'</span></td><td></td><</tr></tbody>';
		}else{
			elem_conteneur=elem_pc;
		}
		lvl_h++;
	}

	if(pi!=""){
        var elem_pi=$('#servers tbody[plugin^="p='+p+'&pc='+pc+'&pi='+pi+'&"]');
        if(elem_pi.length <= 0){
            pi_title='<tbody plugin="p='+p+'&amp;pc='+pc+'&amp;pi='+pi+'&amp;t=&amp;tc=&amp;ti="><tr><td><span lvl="'+lvl_h+'" target="plugin">'+pi+'</span></td><td></td><</tr></tbody>';
        }else{
			elem_conteneur=elem_pi;
		}
        lvl_h++;
    }

	var row="";
    $('#servers th .serverName').each(function(){
        var serverName=$(this).attr('value');
		
		var visible="";
		if($(this).is(':hidden')){
			visible='style="display : none;"';
		}
        row+='<td '+visible+'><div class="div-for-width"><figure><figcaption><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;Loading...</figcaption><img class="imggraph" onload="getTitle($(this),\''+serverName+'\', \''+p+'\', \''+pc+'\', \''+pi+'\', \''+t+'\', \''+tc+'\', \'\');" onerror="hideErrorGraph($(this));" onclick="Show_Popup($(this).attr(\'src\').split(\'?\')[1],\''+time_range["timer"]+'\',\''+time_range['s']+'\',\''+time_range['e']+'\')" title="Click to Zoom" alt="rrd" src="/CGraphz/graph.php?h='+serverName+'&amp;p='+p+'&amp;pc='+pc+'&amp;pi='+pi+'&amp;t='+t+'&amp;tc='+tc+'&amp;ti='+time_range['txt']+'"></figure></div></td>';
    });


	var elem=$('#servers tbody[plugin="p='+p+'&pc='+pc+'&pi='+pi+'&t='+t+'&tc='+tc+'&ti="]');	
    if(row!="" && elem.length <= 0){
        elem_conteneur.first().after(p_title+pc_title+pi_title+'<tbody plugin="p='+p+'&amp;pc='+pc+'&amp;pi='+pi+'&amp;t='+t+'&amp;tc='+tc+'&amp;ti="><tr>'+row+'</tr></tbody>');
    }
}

function getPlugin(obj){
	var niveau=obj.attr('niveau');

    var p="";
    var pc="";
    var pi="";
    var t="";
    var tc="";
    var ti="";

    if(niveau!="plugin"){
        p=obj.attr('plugin');

        if(niveau!="plugin-categorie"){
            pc=obj.attr('plugin-categorie');

            if(niveau!="plugin-instance"){
                pi=obj.attr('plugin-instance');

                if(niveau!="p-type"){
                    t=obj.attr('p-type');

                    if(niveau!="type-categorie"){
                        tc=obj.attr('type-categorie');

                        ti=obj.attr('type-categorie');
                    }else{
                        tc=obj.html();
                    }
                }else{
                    t=obj.html();
                }
            }else{
                pi=obj.html();
            }
        }else{
            pc=obj.html();
        }
    }else{
        p=obj.html();
    }
	return {'p' : p, 'pc' : pc, 'pi' : pi, 't' : t, 'tc' : tc, 'ti' : ti};
}


function removeGraph(id){
	var obj=$('#'+id+' span');

    var plugin=getPlugin(obj);
    var niveau=obj.attr('niveau');

	var p=plugin['p'];
	var pc=plugin['pc'];
	var pi=plugin['pi'];
	var t=plugin['t'];
	var tc=plugin['tc'];	

	if(p=="null") p="";
	if(pc=="null") pc="";
	if(pi=="null") pi="";
	if(t=="null") t="";
	if(tc=="null") tc="";

	var selector="p="+p+"&";

	if(niveau!="plugin"){
		selector+="pc="+pc+"&";

		if(niveau!="plugin-categorie"){
	        selector+="pi="+pi+"&";
		
			if(niveau!="plugin-instance"){
				selector+="t="+t+"&";
			}
		}
	}	
	$('#servers tbody[plugin^="'+selector+'"]').each(function(){
		$(this).remove();
	});

	cleanTitle(p,pc,pi);
}

function cleanTitle(p,pc,pi){
	var elem_pi=$('#servers tbody[plugin^="p='+p+'&pc='+pc+'&pi='+pi+'&"]');
	if(elem_pi.length == 1){
		elem_pi.each(function(){
			$(this).remove();
		});
	}

	var elem_pc=$('#servers tbody[plugin^="p='+p+'&pc='+pc+'&"]');
    if(elem_pc.length == 1){
        elem_pc.each(function(){
            $(this).remove();
        });
    }

	var elem_p=$('#servers tbody[plugin^="p='+p+'&"]');
    if(elem_p.length == 1){
        elem_p.each(function(){
            $(this).remove();
        });
    }

}

function hideErrorGraph(obj){
	obj.parent().hide();
	synchroTitleWithGraph();
}


function removeHost(obj){
	var serverName=obj.parent().children().filter('.serverName').html();
	
	$('td:has(.imggraph[src*="?h='+serverName+'&"])').each(function(){
		$(this).remove();
	});

	obj.parent().remove();
	
	synchroTitleWithGraph();
}

function addHost(hostname){
	var src=$('#servers .imggraph-pattron').attr('src');
    var time_start=getParameterByName(src,'s');
    var time_end=getParameterByName(src,'e');
    var timer=getParameterByName(src,'timer');


	if($('#servers .serverName[value='+hostname+']').length <= 0){
		$('#dashboard_content').animate({scrollLeft:0, scrollTop:0}, 'fast');
		$('tr:has(th)').prepend('<th><span class="serverName" value="'+hostname+'">'+hostname+'</span><a href="#" onclick="removeHost($(this));return false;">&nbsp;<i class="glyphicon glyphicon-remove"></i></a></th>');
		$('tr:has(.imggraph)').prepend('<td><div class="div-for-width"></div></td>');
		
		$('.imggraph[src*="?h=patron-graph&"]').each(function(){
			var src=$(this).attr('src');
			src=src.replace('patron-graph',hostname);
			$(this).parent().parent().parent().parent().children().first().children().first().append('<figure><figcaption>'+hostname+'</figcaption><img class="imggraph" onerror="hideErrorGraph($(this));" onclick="Show_Popup($(this).attr(\'src\').split(\'?\')[1],\''+timer+'\',\''+time_start+'\',\''+time_end+'\')" title="Click to Zoom" alt="rrd" src="'+src+'"></figure>');
		});

		synchroTitleWithGraph();
	}
}

function completeAddHostInput(obj){
	$('#jquery-live-search-add-host').hide();

	$('#serverToAdd').val(obj.html());
}

function getTitle(obj,h, p, pc, pi, t, tc, ti){
	$.ajax({
		url: ajaxURL+"getTitleGraph.ajax.php?h="+h+"&p="+p+"&pc="+pc+"&pi="+pi+"&t="+t+"&tc="+tc+"&ti="+ti,
		context: obj
	}).done(function(title) {
		$( this ).parent().children().first().html(title);
	});
}
