jQuery(document).ready(function($) {

	$('.swf_pagination li a').live('click', function() {
		if (!$(this).parent().hasClass('swf-active')) {
			$('.swf_pagination li').removeClass('swf-active');
			$('.swf_content li').removeClass('swf-active');
			$(this).parent().addClass('swf-active');
			$($(this).attr('href')).addClass('swf-active');
		}

		return false;
	});

	$('#swf_fonts').change(function() {
		$("#swf_fonts").after('<img src="/wp-content/plugins/simple-web-fonts/images/ajax-loader.gif" alt="" class="loader" />');
		var data = {
			action: 'my_action',
			font: $('#swf_fonts option:selected').val()
		};
		console.log(data);
		$.post(ajaxurl, data, function(response) {
			console.log(response);
			$(".loader").remove();
			$("#swf-font-preview").html(response);
		});
	});

});