$( document ).ready(function() {
	$('#radio-holder .col input').iCheck({
		radioClass: 'iradio_minimal',
		increaseArea: '20%' // optional
	});
	$( "#accordion" ).accordion({
			collapsible: false,
			heightStyle: "content"
		});
});