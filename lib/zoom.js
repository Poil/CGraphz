$(function () {
	$('#f_time_start').datetimepicker({
		language:'en-24h',
		maxDate:moment().format('YYYY-MM-DD HH:mm')
	});

	$('#f_time_end').datetimepicker({
		language:'en-24h',
		maxDate:moment().format('YYYY-MM-DD HH:mm')
	});

	$('#f_time_start').keyup(function(e) {
		if(e.keyCode == 13) {
			$('#f_time_start').data("DateTimePicker").hide();
		}
	});

	$('#f_time_end').keyup(function(e) {
		if(e.keyCode == 13) {
		$('#f_time_end').data("DateTimePicker").hide();
		}
	});

	$('.list-unstyled').append("<li><button name='valideDate' type='button' class='btn btn-default datetimepickerSubmit' style='width:100%;' >Submit</button></li>");

	$('.datetimepickerSubmit').on('click',function(){
		$('#f_time_start').data("DateTimePicker").hide();
		$('#f_time_end').data("DateTimePicker").hide();
	});

	$('div#popupModal button.close').on('click',function(){
		$('#f_time_start').data("DateTimePicker").hide();
		$('#f_time_end').data("DateTimePicker").hide();
	});

	$('#f_time_start').on('click',function(){
		$('#f_time_start').data("DateTimePicker").show();
		$('#f_time_end').data("DateTimePicker").hide();
	});

	$('#f_time_end').on('click',function(){
		$('#f_time_end').data("DateTimePicker").show();
		$('#f_time_start').data("DateTimePicker").hide();
	});
});


