/* French initialisation for the jQuery UI date picker plugin. */
/* Written by Keith Wood (kbwood{at}iinet.com.au),
              Stéphane Nahmani (sholby@sholby.net),
              Stéphane Raimbault <stephane.raimbault@gmail.com> */
jQuery(function($){
	$.timepicker.regional['en'] = {
		hourText: 'Hour',             // Define the locale text for "Hours"
		minuteText: 'Minute',         // Define the locale text for "Minute"
		amPmText: ['AM', 'PM']       // Define the locale text for periods
	};
	$.timepicker.setDefaults($.timepicker.regional['en']);
});
