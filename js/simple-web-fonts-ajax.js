jQuery(document).ready(function($) {

	// var data = {
	// 	action: 'my_action',
	// 	whatever: 1234
	// };

	// // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	// jQuery.post(ajaxurl, data, function(response) {
	// 	alert('Got this from the server: ' + response);
	// });


	jQuery('#swf_fonts').change(function() {
		jQuery("#swf_fonts").after('<img src="/wp-content/plugins/simple-web-fonts/images/ajax-loader.gif" alt="" class="swf-loader" />');
		var data = {
			action: 'my_action',
			font: jQuery('#swf_fonts option:selected').val()
		};
		console.log(data);
		jQuery.post(ajaxurl, data, function(response) {
			jQuery(".swf-loader").remove();
			jQuery(".swf-font-preview").html(response);
		});
	});
});