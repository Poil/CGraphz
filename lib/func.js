function genUrl(id_config_server, id_config_project) {
	var cur_url=removeqsvar(removeqsvar(window.location.href,'f_id_config_server'),'f_id_config_project');
	
	return cur_url+'&f_id_config_project='+id_config_project+'&f_id_config_server='+id_config_server;
	
}
function gup(url, name) {
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( url );
	if( results == null ) {
		return false
	}
	else {
		return true
	}
}

function refresh_graph(id,time_range,time_start,time_end) {
	var imgsrc;

	// On genere un timestamp
	var timer1 = new Date();
	var timer2 = timer1.getTime(); 

	$('#'+id+'> .imggraph').each(function(image) {
		// On vire le timer qui sert a forcer le refesh
		imgsrc=removeqsvar(this.src,'timer');
		if (time_range!='') {
			imgsrc=removeqsvar(imgsrc,'s');
			imgsrc=removeqsvar(imgsrc,'e');
			imgsrc+='&s='+time_range;
		} else if (time_start!='' && time_end!='') {
			imgsrc=removeqsvar(imgsrc,'s');
			imgsrc=removeqsvar(imgsrc,'e');
			imgsrc+='&s='+time_start+'&e='+time_end;
		} 
		// On ajoute un timestamp a la fin pour forcer le refresh
		imgsrc+='&timer='+timer2;

		$(this).attr('src',imgsrc);
	});

	if (time_range!='') {
		var attrjs="Show_Popup($(this).prev('img').attr('src').split('?')[1],'"+time_range+"','','')";
		$('#dashboard'+'> .imgzoom').attr('onClick',attrjs);

	} else if (time_start!='' && time_end!='') {
		var attrjs="Show_Popup($(this).prev('img').attr('src').split('?')[1],'','"+time_start+"','"+time_end+"')";
		$('#dashboard'+'> .imgzoom').attr('onClick',attrjs);
	}

	if (time_start!='' && time_end!='') {
		$.ajax({
			url: 'html/form/commun/ajax_set_timerange.php?time_start='+time_start+'&time_end='+time_end,
			context: document.body,
		});
	} else if (time_range!='') {
		$.ajax({
			url: 'html/form/commun/ajax_set_timerange.php?time_range='+time_range,
			context: document.body,
		});
	}
}

function GetQueryString(url, varname) {
	var reg = new RegExp("(^|&)"+ varname +"=([^&]*)(&|$)");
	var r = url.search.substr(1).match(reg);
	if (r!=null) return unescape(r[2]); return null;
}

function removeqsvar(url, varname) {
	var urlparts = url.split('?');
	if (urlparts.length>=2) {
		urlparts[1]=clearqsvar(urlparts[1], varname);
		/*
		var prefix= encodeURIComponent(varname)+'=';
		var reg = new RegExp("[&;]+", "g");
		var pars=urlparts[1].split(reg);
		for (var i= pars.length; i-->0;) {
			if (pars[i].lastIndexOf(prefix, 0) != -1) {
			    pars.splice(i, 1);
			}
		}
		url=urlparts[0]+'?'+pars.join('&');*/
		url=urlparts[0]+'?'+urlparts[1];
	} 
	return url;
}

function clearqsvar(url, varname) {
	var prefix= encodeURIComponent(varname)+'=';
	var reg = new RegExp("[&;]+", "g");
	var pars=url.split(reg);
	for (var i= pars.length; i-->0;) {
		if (pars[i].lastIndexOf(prefix, 0) != -1) {
		    pars.splice(i, 1);
		}
	}
	url=pars.join('&');
	return url;
}

function build_zoom_frame(target, txt_range_start, txt_range_end) {
	var form = document.createElement('form');
	form.className = 'form-inline';
	form.role = 'form';

	var start_div = document.createElement('div');
	start_div.className = 'form-group';
	var start_label = document.createElement('label');
	start_label.className = 'sr-only';
	start_label.htmlFor = 'f_time_start'
	var start_text_label = txt_range_start;
	var start_input = document.createElement('input');
	start_input.type = 'text';
	start_input.type.className = 'form-control';
	start_input.id = 'f_time_start';
	start_input.placeholder = txt_range_start;

	var end_div = document.createElement('div');
	end_div.className = 'form-group';
	var end_label = document.createElement('label');
	end_label.className = 'sr-only';
	end_label.htmlFor = 'f_time_end'
	var end_text_label = txt_range_end;
	var end_input = document.createElement('input');
	end_input.type = 'text';
	end_input.type.className = 'form-control';
	end_input.id = 'f_time_end';
	end_input.placeholder = txt_range_end;

	var submit = document.createElement('button');
	submit.className = 'btn btn-default';
	var submitdb = document.createElement('button');
	submitdb.className = 'btn btn-default';

	var script = document.createElement('script');
	script.src = 'lib/zoom.js';
	script.onload = function() {}
	document.getElementsByTagName('head')[0].appendChild(script);

	form.appendChild(start_div);
	start_div.appendChild(start_label);
	//start_label.appendChild(start_text_label);
	start_div.appendChild(start_input);

	form.appendChild(end_div);
	end_div.appendChild(end_label);
	//end_label.appendChild(end_text_label);
	end_div.appendChild(end_input);

	form.appendChild(submit);
	form.appendChild(submitdb);

	document.getElementById('popup').appendChild(form);
}

function Show_Popup(url,time_range,time_start,time_end) {
	if (time_range!='') {
		url=clearqsvar(url,'s');
		url=clearqsvar(url,'e');
		url+='&s='+time_range;
	} else if (time_start!='' && time_end!='') {
		url=clearqsvar(url,'s');
		url=clearqsvar(url,'e');
		url+='&s='+time_start+'&e='+time_end;   
	}

	$.getJSON('html/form/commun/ajax_get_timerange.php', function(data) {
		var items = [];
		$.each(data, function(key, val) {
			var myDate = new Date();
			myDate.setTime(val*1000);
			var myDateF=dateFormat(myDate,"yyyy-mm-dd HH:MM");
			$('#f_'+key).val(myDateF);
		});
	});

	var currentTime = new Date();
	var currentYear = currentTime.getFullYear();
	var currentMonth = currentTime.getMonth();
	var currentDate = currentTime.getDate();
	var currentHours = currentTime.getHours();
	var currentMinutes = currentTime.getMinutes();

	$('#popup').load('html/dashboard/zoom/d_zoom.php?'+url+'&graph_type=canvas', function() {
		$('#popup').fadeIn('fast');
		$('#popupModal').draggable({ cancel: 'canvas', scroll: true});
		
		$('#f_time_start').datetimepicker({
			dateFormat: 'yy-mm-dd', 
			timeFormat: 'HH:mm',
			maxDateTime: new Date(currentYear, currentMonth, currentDate, currentHours, currentMinutes)
				
		});

		$('#f_time_end').datetimepicker({
			dateFormat: 'yy-mm-dd', 
			timeFormat: 'HH:mm',
			maxDateTime: new Date(currentYear, currentMonth, currentDate, currentHours, currentMinutes)
		});

		drawAll();
	});

//	build_zoom_frame($('#popup'), 'start', 'end');
}


function Close_Popup() {
	$('#popupModal').modal('hide');
}

function Calc_Timestamp(input_ts, input_hour) {
	var ts=$('#'+input_ts).val()/1000;
	
	var elem=$('#'+input_hour).val().split(':');
	var hour_ts=parseInt(elem[0])*3600;
	var min_ts=parseInt(elem[1])*60;
	
	ts=ts+hour_ts+min_ts;
	
	return ts;
}

function date_to_ts(elem) {
	return $.strtotime($('#'+elem).val());
}

function LoadOptions(myurl, mytarget) {
	$.ajax({
	    type: 'GET',
	    url: myurl,
	    dataType: 'json',
	    success: function(json) { 
			var options ='' ;
	
			for (var i=0; i<json.length; i++) {
				options+='<option value="'+ json[i].optionValue + '">' + json[i].optionDisplay + '</option>';
			}
			$('select#'+mytarget).html(options);
		},
	    data: {},
	    async: false
	});
}



