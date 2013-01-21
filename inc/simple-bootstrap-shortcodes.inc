<?php

	/************************************************************************/
	/* Remove the 2 main auto-formatters when wrapped in RAW tags
	/************************************************************************/

	remove_filter('the_content', 'wpautop');
	remove_filter('the_content', 'wptexturize');

	/************************************************************************/
	/* ENABLE SHORTCODES FOR TEXT WIDGETS
	/************************************************************************/

	add_filter('widget_text', 'shortcode_unautop');
	add_filter('widget_text', 'do_shortcode', 11);


	/************************************************************************/
	/* INSTAGRAM FEED SHORTCODE
	/************************************************************************/

	function bootstrap_shortcode( $atts, $content = null ) {

		// GET SHORTCODE OPTIONS
		extract( shortcode_atts( array(
			'count' => 100
		), $atts ));

		$output;

		return $output;

	}

	add_shortcode('instagram_feed', 'bootstrap_shortcode');

?>