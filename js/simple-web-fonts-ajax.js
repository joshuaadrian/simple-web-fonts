jQuery(document).ready(function($) {

	$('#swf_fonts').change(function() {
		$("#swf_fonts").after('<img src="/wp-content/plugins/simple-web-fonts/images/ajax-loader.gif" alt="" class="swf-loader" />');
		var data = {
			action: 'my_action',
			font: $('#swf_fonts option:selected').val()
		};
		$.post(ajaxurl, data, function(response) {
			$(".swf-loader").remove();
			$(".swf-font-preview").html(response);
		});
	});

});