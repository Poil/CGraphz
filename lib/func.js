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

		this.src=imgsrc;
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
		var prefix= encodeURIComponent(varname)+'=';
		var reg = new RegExp("[&;]+", "g");
		var pars=urlparts[1].split(reg);
		for (var i= pars.length; i-->0;) {
			if (pars[i].lastIndexOf(prefix, 0) != -1) {
			    pars.splice(i, 1);
			}
		}
		url=urlparts[0]+'?'+pars.join('&');
	} 
	return url;
}

function Show_Popup(url,time_range,time_start,time_end) {
	 if (time_range!='') {
                url=removeqsvar(url,'s');
                url+='&s='+time_range;
        } else if (time_start!='' && time_end!='') {
                url=removeqsvar(url,'s');
                url=removeqsvar(url,'e');
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
		$('#mask').fadeIn('fast');
		$('#popup').fadeIn('fast');
		$( "#popup" ).draggable({ handle: '#move_popup', containment: "#mask", scroll: false });
		
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
}

function Close_Popup() {
	$('#mask').fadeOut('fast');
	$('#popup').fadeOut('fast');
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



