<?php

function my_action_callback() {
	global $wpdb; // this is how you get access to the database

	$options = get_option('swf_options');

	foreach($options['google_fonts'] as $font) {
		if ($font['name'] == $_POST['font']) {
			$available_weights;
			foreach($font['weights'] as $weight) {
				$available_weights .= $weight . ',';
				echo '<p style="font-family:\''.$_POST['font'].'\'; font-weight:';
				if (strlen($weight) > 3) {
					echo substr($weight, 0, 3) . ';font-style:italic;';
				} else {
					echo $weight . ';';
				}
				echo '"><input name="swf_options[selected_weights][]" type="checkbox" value="'.$weight.'"';
				foreach($options['selected_weights'] as $selected_weight) {
					if ($font['name'] == $options['selected_font']) {
						checked($weight, $selected_weight);
					}
				}
				echo '/>'.$weight.' &ndash; Grumpy wizards make toxic brew for the evil Queen and Jack.</p>';
			}
			echo '<link href="http://fonts.googleapis.com/css?family='.urlencode($_POST['font']).':'.substr($available_weights, 0, -1).'" rel="stylesheet" type="text/css">';
		}
	}

	die(); // this is required to return a proper result
}

add_action('wp_ajax_my_action', 'my_action_callback');

remove_action( 'wp_head', 'rsd_link' );
// windows live writer
remove_action( 'wp_head', 'wlwmanifest_link' );
// index link
remove_action( 'wp_head', 'index_rel_link' );
// previous link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
// start link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
// links for adjacent posts
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
// WP version
remove_action( 'wp_head', 'wp_generator' );

// remove WP version from scripts
function remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

add_filter( 'style_loader_src', 'remove_wp_ver_css_js', 9999 );
// remove Wp version from scripts
add_filter( 'script_loader_src', 'remove_wp_ver_css_js', 9999 );

?>