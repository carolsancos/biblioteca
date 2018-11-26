$(document).ready(function(){

	$('#datepicker').datepicker({
		dateFormat: 'dd/mm/yy', altField: '#dbdatepicker', altFormat: 'yy-mm-dd'
	});
   
	// Show datepicker on click on the calendar icon
	$("#calendar-icon").on("click", function(){
        $(this).siblings("input").datepicker("show");    
    });

} );