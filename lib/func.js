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
		imgsrc=removeqsvar(imgsrc,'e');
		if (time_range!='') {
			imgsrc=removeqsvar(imgsrc,'s');
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
		var attrjs="Show_Popup($(this).prev('img').attr('src')+'&amp;x=800&amp;y=350','"+time_range+"','','')";
		$('#dashboard'+'> .imgzoom').attr('onClick',attrjs);

	} else if (time_start!='' && time_end!='') {
		var attrjs="Show_Popup($(this).prev('img').attr('src')+'&amp;x=800&amp;y=350','','"+time_start+"','"+time_end+"')";
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
	$('#mask').fadeIn('fast');
	$('#popup').fadeIn('fast');


	if (time_range!='') {
		url=removeqsvar(url,'s');
		url+='&s='+time_range;
	} else if (time_start!='' && time_end!='') {
		url=removeqsvar(url,'s');
		url=removeqsvar(url,'e');
		url+='&s='+time_start+'&e='+time_end;	}
	

	$('#popup').html('<img src="'+url+'" class="imggraph" />');
	Add_Form($('#popup'));
	Close_Button($('#popup'));
	Move_Button($('#popup'));
	
	$(function() {
		$( "#popup" ).draggable({ handle: '#move_popup', containment: "#mask", scroll: false });
	});
}

function Close_Popup() {
	$('#mask').fadeOut('fast');
	$('#popup').fadeOut('fast');
}

function Close_Button(element) {
	element.prepend('<img id="close_popup" src="img/close.png" title="Fermer" alt="x"  onclick="Close_Popup();" />');
}

function Move_Button(element) {
	element.prepend('<img id="move_popup" src="img/drag.png" title="Move" alt="&lt;-&gt;" />');
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

function Add_Form(element) {

	var submit="refresh_graph('popup','',date_to_ts('f_time_start'),date_to_ts('f_time_end')); return false";
	var myhtml='<form name="f_form_time_selection" method="post" action="" onsubmit="'+submit+'" >';
		myhtml+='<label for="f_time_start">Début</label><input type="text" name="f_time_start" id="f_time_start" size="13" maxlength="16" readonly="readonly" /><br />';
		myhtml+='<label for="f_time_end">Fin</label><input type="text" name="f_time_end" id="f_time_end" size="13" maxlength="16" readonly="readonly" /><br />';
		myhtml+='<input type="submit" value="Envoyer" />';
		myhtml+='<input type="button" value="Envoyer sur TdB" onclick="refresh_graph(\'dashboard\',\'\',date_to_ts(\'f_time_start\'),date_to_ts(\'f_time_end\')); Close_Popup(); return false" />';
		myhtml+='</form>';
	
	element.prepend(myhtml);

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
	
	$(function() {
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
	});	
}

function LoadOptions(myurl, mytarget) {
	/*$.getJSON(myurl,{ajax: 'true'}, function(json) {
		var options ='' ;

		for (var i=0; i<json.length; i++) {
			options+='<option value="'+ json[i].optionValue + '">' + json[i].optionDisplay + '</option>';
		}
		$('select#'+mytarget).html(options);
	});*/
	
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


/*
 * Date Format 1.2.3
 * (c) 2007-2009 Steven Levithan <stevenlevithan.com>
 * MIT license
 *
 * Includes enhancements by Scott Trenda <scott.trenda.net>
 * and Kris Kowal <cixar.com/~kris.kowal/>
 *
 * Accepts a date, a mask, or a date and a mask.
 * Returns a formatted version of the given date.
 * The date defaults to the current date/time.
 * The mask defaults to dateFormat.masks.default.
 */

var dateFormat = function () {
	var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
		timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
		timezoneClip = /[^-+\dA-Z]/g,
		pad = function (val, len) {
			val = String(val);
			len = len || 2;
			while (val.length < len) val = "0" + val;
			return val;
		};

	// Regexes and supporting functions are cached through closure
	return function (date, mask, utc) {
		var dF = dateFormat;

		// You can't provide utc if you skip other args (use the "UTC:" mask prefix)
		if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
			mask = date;
			date = undefined;
		}

		// Passing date through Date applies Date.parse, if necessary
		date = date ? new Date(date) : new Date;
		if (isNaN(date)) throw SyntaxError("invalid date");

		mask = String(dF.masks[mask] || mask || dF.masks["default"]);

		// Allow setting the utc argument via the mask
		if (mask.slice(0, 4) == "UTC:") {
			mask = mask.slice(4);
			utc = true;
		}

		var	_ = utc ? "getUTC" : "get",
			d = date[_ + "Date"](),
			D = date[_ + "Day"](),
			m = date[_ + "Month"](),
			y = date[_ + "FullYear"](),
			H = date[_ + "Hours"](),
			M = date[_ + "Minutes"](),
			s = date[_ + "Seconds"](),
			L = date[_ + "Milliseconds"](),
			o = utc ? 0 : date.getTimezoneOffset(),
			flags = {
				d:    d,
				dd:   pad(d),
				ddd:  dF.i18n.dayNames[D],
				dddd: dF.i18n.dayNames[D + 7],
				m:    m + 1,
				mm:   pad(m + 1),
				mmm:  dF.i18n.monthNames[m],
				mmmm: dF.i18n.monthNames[m + 12],
				yy:   String(y).slice(2),
				yyyy: y,
				h:    H % 12 || 12,
				hh:   pad(H % 12 || 12),
				H:    H,
				HH:   pad(H),
				M:    M,
				MM:   pad(M),
				s:    s,
				ss:   pad(s),
				l:    pad(L, 3),
				L:    pad(L > 99 ? Math.round(L / 10) : L),
				t:    H < 12 ? "a"  : "p",
				tt:   H < 12 ? "am" : "pm",
				T:    H < 12 ? "A"  : "P",
				TT:   H < 12 ? "AM" : "PM",
				Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
				o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
				S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
			};

		return mask.replace(token, function ($0) {
			return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
		});
	};
}();

// Some common format strings
dateFormat.masks = {
	"default":      "ddd mmm dd yyyy HH:MM:ss",
	shortDate:      "m/d/yy",
	mediumDate:     "mmm d, yyyy",
	longDate:       "mmmm d, yyyy",
	fullDate:       "dddd, mmmm d, yyyy",
	shortTime:      "h:MM TT",
	mediumTime:     "h:MM:ss TT",
	longTime:       "h:MM:ss TT Z",
	isoDate:        "yyyy-mm-dd",
	isoTime:        "HH:MM:ss",
	isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
	isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

// Internationalization strings
dateFormat.i18n = {
	dayNames: [
		"Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
		"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
	],
	monthNames: [
		"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
		"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
	]
};

// For convenience...
Date.prototype.format = function (mask, utc) {
	return dateFormat(this, mask, utc);
};


