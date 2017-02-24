/**
 * Unicorn Admin Template
 * Diablo9983 -> diablo9983@gmail.com
**/
$(document).ready(function(){
	
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').select2();
    //$('.colorpicker').colorpicker();
    $('.datepicker').datepicker();
    $('.dtp1').datepicker({
		language: 'pt-BR',
		maskInput: true,           // disables the text input mask
		pickDate: true,            // disables the date picker
		pickTime: true,            // disables de time picker
		pick12HourFormat: false,   // enables the 12-hour format time picker
		pickSeconds: false,         // disables seconds in the time picker
		startDate: -Infinity,      // set a minimum date
		endDate: Infinity          // set a maximum date
	});
});
