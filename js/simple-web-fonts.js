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

	var fontBase = 20;

	$('#swf-smaller').click(function() {
		if (fontBase > 12) {
			fontBase = fontBase - 2;
			$('.swf-font-preview').css('font-size',fontBase+'px');
		}
		return false;
	});

	$('#swf-larger').click(function() {
		if (fontBase < 40) {
			fontBase = fontBase + 2;
			$('.swf-font-preview').css('font-size',fontBase+'px');
		}
		return false;
	});

});