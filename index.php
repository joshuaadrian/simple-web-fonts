<?php

/*
Plugin Name: Simple Web Fonts
Plugin URI: http://joshuaadrian.com/simple-web-fonts-plugin/
Description: Simply add Google web fonts to your WordPress theme.
Author: Joshua Adrian
Version: 0.5.0
Author URI: http://joshuaadrian.com
*/

/************************************************************************/
/* ERROR LOGGING
/************************************************************************/

/**
 *  Simple logging function that outputs to debug.log if enabled
 *  _log('Testing the error message logging');
 *	_log(array('it' => 'works'));
 */

if (!function_exists('_log')) {
  function _log( $message ) {
    if( WP_DEBUG === true ){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( print_r( $message, true ) );
      } else {
        error_log( $message );
      }
    }
  }
}

/************************************************************************/
/* DEFINE PLUGIN ID AND NICK
/************************************************************************/

// DEFINE PLUGIN BASE
define( 'SWF_PATH', plugin_dir_path(__FILE__) );
// DEFINE PLUGIN ID
define( 'SWF_PLUGINOPTIONS_ID', 'simple-web-fonts' );
// DEFINE PLUGIN NICK
define( 'SWF_PLUGINOPTIONS_NICK', 'Simple Web Fonts' );
// DEFINE PLUGIN NICK
register_activation_hook( __FILE__, 'swf_add_defaults' );
// DEFINE PLUGIN NICK
register_uninstall_hook( __FILE__, 'swf_delete_plugin_options' );
// ADD LINK TO ADMIN
add_action( 'admin_init', 'swf_init' );
// ADD LINK TO ADMIN
add_action( 'admin_menu', 'swf_add_options_page' );
// ADD LINK TO ADMIN
add_filter( 'plugin_action_links', 'swf_plugin_action_links', 10, 2 );


/************************************************************************/
/* ADD LOCALIZATION FOLDER
/************************************************************************/

function swf_plugin_setup() {
    load_plugin_textdomain( 'simple-web-fonts', false, dirname(plugin_basename(__FILE__)) . '/lang/' );
}

add_action( 'after_setup_theme', 'swf_plugin_setup' );

/************************************************************************/
/* Delete options table entries ONLY when plugin deactivated AND deleted
/************************************************************************/

function swf_delete_plugin_options() {
	delete_option( 'swf_options' );
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_activation_hook(__FILE__, 'posk_add_defaults')
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE PLUGIN IS ACTIVATED. IF THERE ARE NO THEME OPTIONS
// CURRENTLY SET, OR THE USER HAS SELECTED THE CHECKBOX TO RESET OPTIONS TO THEIR
// DEFAULTS THEN THE OPTIONS ARE SET/RESET.
//
// OTHERWISE, THE PLUGIN OPTIONS REMAIN UNCHANGED.
// ------------------------------------------------------------------------------

// Define default option settings
function swf_add_defaults() {
	$tmp = get_option('swf_options');
    if(($tmp['chk_default_options_db']=='1')||(!is_array($tmp))) {
		delete_option('swf_options'); // so we don't have to reset all the 'off' checkboxes too! (don't think this is needed but leave for now)
		$arr = array(
			'google_fonts' => array(
				array(
					'name' => 'Droid Sans',
					'weights' => array(
						'400',
						'700'
					),
					'type' => 'Sans Serif'
				),
				array(
					'name' => 'Lato',
					'weights' => array(
						'100',
						'300',
						'400',
						'700',
						'900',
						'100italic',
						'300italic',
						'400italic',
						'700italic',
						'900italic'
					),
					'type' => 'Sans Serif'
				),
				array(
					'name' => 'Open Sans',
					'weights' => array(
						'300',
						'400',
						'600',
						'700',
						'800',
						'300italic',
						'400italic',
						'600italic',
						'700italic',
						'800italic'
					),
					'type' => 'Sans Serif'
				),
				array(
					'name' => 'PT Sans',
					'weights' => array(
						'400',
						'700',
						'400italic',
						'700italic'
					),
					'type' => 'Sans Serif'
				),
				
				array(
					'name' => 'Arvo',
					'weights' => array(
						'400',
						'700',
						'400italic',
						'700italic'
					),
					'type' => 'Slab Serif'
				),
				array(
					'name' => 'Josefin Slab',
					'weights' => array(
						'100',
						'300',
						'400',
						'600',
						'700',
						'100italic',
						'300italic',
						'400italic',
						'600italic',
						'700italic'
					),
					'type' => 'Slab Serif'
				),
				array(
					'name' => 'Abril Fatface',
					'weights' => array(
						'400'
					),
					'type' => 'Serif'
				),
				array(
					'name' => 'Old Standard TT',
					'weights' => array(
						'400',
						'700',
						'400italic'
					),
					'type' => 'Serif'
				),
				array(
					'name' => 'PT Serif',
					'weights' => array(
						'400',
						'700',
						'400italic',
						'700italic'
					),
					'type' => 'Serif'
				),
				array(
					'name' => 'Vollkorn',
					'weights' => array(
						'400',
						'700',
						'400italic',
						'700italic'
					),
					'type' => 'Serif'
				),

			),
			'selected_font' => 'Open Sans',
			'selected_font_type' => 'Sans Serif',
			'selected_weights' => array(
				'300',
				'400',
				'600',
				'700',
				'800',
				'300italic',
				'400italic',
				'600italic',
				'700italic',
				'800italic'
			)
		);
		update_option('swf_options', $arr);
	}
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_init', 'posk_init' )
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE 'admin_init' HOOK FIRES, AND REGISTERS YOUR PLUGIN
// SETTING WITH THE WORDPRESS SETTINGS API. YOU WON'T BE ABLE TO USE THE SETTINGS
// API UNTIL YOU DO.
// ------------------------------------------------------------------------------

// Init plugin options to white list our options
function swf_init() {
	register_setting( 'swf_plugin_options', 'swf_options', 'swf_validate_options' );
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_menu', 'posk_add_options_page');
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE 'admin_menu' HOOK FIRES, AND ADDS A NEW OPTIONS
// PAGE FOR YOUR PLUGIN TO THE SETTINGS MENU.
// ------------------------------------------------------------------------------

// Add menu page
function swf_add_options_page() {
	add_options_page('Simple Web Fonts', '<img class="menu_sb" src="' . plugins_url( 'images/swf-icon.gif' , __FILE__ ) . '" alt="" />'.SWF_PLUGINOPTIONS_NICK, 'manage_options', SWF_PLUGINOPTIONS_ID, 'swf_render_form');
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION SPECIFIED IN: add_options_page()
// ------------------------------------------------------------------------------
// THIS FUNCTION IS SPECIFIED IN add_options_page() AS THE CALLBACK FUNCTION THAT
// ACTUALLY RENDER THE PLUGIN OPTIONS FORM AS A SUB-MENU UNDER THE EXISTING
// SETTINGS ADMIN MENU.
// ------------------------------------------------------------------------------

// Render the Plugin options form
function swf_render_form() { ?>
	<div class="wrap">

	    <?php screen_icon(); ?>

		    <h2>Simple Web Fonts Settings</h2>

		    <ul class="swf_pagination group">
		    	<li class="swf-active" id="swf-pagination-settings">
		    		<a href="#swf-settings">Settings</a>
		    	</li>
		    	<li id="swf-pagination-usage">
		    		<a href="#swf-usage">Usage</a>
		    	</li>
		    </ul>
		    <form action="options.php" method="post" id="<?php echo SWF_PLUGINOPTIONS_ID; ?>-options-form" name="<?php echo SWF_PLUGINOPTIONS_ID; ?>-options-form">
		    <ul class="swf_content">
		    	<li id="swf-settings" class="swf-active">
			    		
		    			<?php
		    				settings_fields('swf_plugin_options');
								$options = get_option('swf_options');
		    			?>

			    		<table class="form-table">
					    	<tr>
						    	<th>
						    		<h3>Google Web Fonts</h3>
						    	</th>
							</tr>
							<tr>
								<th>Font Specimens</th>
						    	<td>
						    		<select id="swf_fonts" name='swf_options[selected_font]'>
										<option value='none' <?php selected('none', $options['selected_font']); ?>>&mdash; None &mdash;</option>
										<?php
										$available_weights;
										foreach($options['google_fonts'] as $key => $value) {
											echo '<option value="'.$value['name'] . '"';
											selected($value['name'], $options['selected_font']);
											echo '>'.$value['name'].' &ndash; '.$value['type'].'</option>';
											if ($value['name'] == $options['selected_font']) {
												foreach($value['weights'] as $weight) {
													$available_weights .= $weight . ',';
												}
											}
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<th>Font Style/Weight Preview</th>
								<td>
									<p id="swf-font-sizing" class="group"><a href="#" id="swf-larger" class="button">+ Larger</a><a href="#" id="swf-smaller" class="button">&ndash; Smaller</a></p>
									<div class="swf-font-preview">

										<link href='http://fonts.googleapis.com/css?family=<?php echo urlencode($options['selected_font']); ?>:<?php echo substr($available_weights, 0, -1); ?>' rel='stylesheet' type='text/css'>
										<?php
										foreach($options['google_fonts'] as $font) {
											if ($font['name'] == $options['selected_font']) {
												foreach($font['weights'] as $weight) {

													echo '<p style="font-size:1em; font-family:\''.$options['selected_font'].'\'; font-weight:';
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
											}
										}
										?>
									</div>
								</td>
							</tr>
						</table>

		    	</li>
		    	<li id="swf-usage">
		    		<?php 
		    			$serif = ', Georgia, Times New Roman, serif;';
		    			$sans_serif = ', Arial, Helvetica, sans-serif;';
		    			$italics = false;
		    		?>
		    		<div class="swf-copy">
						<h2>How to use the selected Google Web Font '<?php echo $options['selected_font']; ?>'</h2>

						<h3>Setting the CSS font family property</h3>
						
						<p>To set the font family use the following:</p>
						<p><code>font-family: '<?php echo $options['selected_font']; ?>';</code></p>
						<p>You may desiginate a font stack like the following:</p>
						<p><code>font-family: <?php echo '\''.$options['selected_font'].'\''; if ($options['selected_font_type'] == 'Serif') { echo $serif; } else { echo $sans_serif; }; ?></code></p>
						
						<h3>Setting the CSS font weight property</h3>
						
						<p>To set the font weight use the following:</p>
						<code>font-weight: '<?php echo $options['selected_weights'][0]; ?>';</code>
						<p>The weights you have selected for this font are:</p>
						<p>
						<?php

						foreach($options['selected_weights'] as $weight) {
							if (strlen($weight) < 5) {
								echo '<code>font-weight: \''.$weight.'\';</code>';
							} else {
								$italics = true;
							}
						}
						echo '</p>';
						if ($italics) {
						?>

						<h3>Setting the CSS font style property</h3>
						
						<p>You have included italic font(s), to set the CSS font style to use italics use the following:</p>
						<p><code>font-style: 'italic';</code></p>
						<?php
						}
						?>

						<h3>You may combine all of the above in the CSS font shorthand declaration:</h3>
						<p><code>font:<?php if ($italics) echo ' italic '; echo ' '.$options['selected_weights'][0]?> 18px/1.5 <?php echo '\''.$options['selected_font'].'\''; if ($options['selected_font_type'] == 'Serif') { echo $serif; } else { echo $sans_serif; }; ?></code></p>
						<p>In order the declarations are font-style, font-weight, font-size/line-height, font-family</p>

						<h3>Any questions or comments about this plugin please email me</h3>
						<p><a href="mailto:joshua@joshuaadrian.com?subject=Questions%2FComments%20about%20<?php echo SWF_PLUGINOPTIONS_NICK; ?>%20plugin">joshua@joshuaadrian.com</a></p>
						
						<?php //print_r($options); ?>

					</div>
					<?php
					//echo 'PLUGIN PATH => ' . SWF_PATH . '<br />';
					//var_dump($options);
					?>			
		    	</li>
		    </ul>
			
		    <p class="submit"><input name="Submit" type="submit" value="<?php esc_attr_e('Update Settings'); ?>" class="button-primary" /></p>
		</form>
		<div class="credits">
			<p>Simple Web Fonts Plugin | Version 0.1.0 | <a href="http://www.joshuaadrian.com/simple-web-fonts-plugin/" target="_blank">Website</a> | Author <a href="http://joshuaadrian.com" target="_blank">Joshua Adrian</a> | <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" style="position:relative; top:3px; margin-left:3px"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/80x15.png" /></a><a href="http://joshuaadrian.com" target="_blank" class="alignright"><img src="<?php echo plugins_url( 'images/ja-logo.gif' , __FILE__ ); ?>" alt="Joshua Adrian" /></a></p>
		</div>
	</div>
<?php
}

/************************************************************************/
/* Sanitize and validate input. Accepts an array, return a sanitized array.
/************************************************************************/

function swf_validate_options($input) {
	$options = get_option('swf_options');
	$selected_font = $input['selected_font'];
	$fonts = $options['google_fonts'];
	$input['selected_font'] = wp_filter_nohtml_kses($input['selected_font']);
	$input['google_fonts'] = $options['google_fonts'];
	$selected_weights = array();
	$weights = $input['selected_weights'];
	foreach($weights as $weight) {
		array_push($selected_weights, $weight);
	}
	$input['selected_weights'] = $selected_weights;
	foreach($fonts as $font) {
		if ($font['name'] == $selected_font) {
			$input['selected_font_type'] = $font['type'];
		}
	}
	return $input;
}

/************************************************************************/
/* Display a Settings link on the main Plugins page
/************************************************************************/

function swf_plugin_action_links( $links, $file ) {
	$tmp_id = SWF_PLUGINOPTIONS_ID . '/index.php';
	if ($file == $tmp_id) {
		$swf_links = '<a href="'.get_admin_url().'options-general.php?page='.SWF_PLUGINOPTIONS_ID.'">'.__('Settings').'</a>';
		// make the 'Settings' link appear first
		array_unshift( $links, $swf_links );
	}
	return $links;
}

/************************************************************************/
/* IMPORT CSS AND JAVASCRIPT STYLES
/************************************************************************/

function swf_plugin_enqueue() {
  wp_register_style('simple_web_fonts_css', plugins_url('/css/simple-web-fonts.css', __FILE__), false, '1.0.0');
  wp_enqueue_style('simple_web_fonts_css');
  wp_enqueue_script('simple_web_fonts_scripts', plugins_url('/js/simple-web-fonts.min.js', __FILE__), array('jquery'));
  wp_enqueue_script('simple_web_fonts_scripts-ajax', plugins_url('/js/simple-web-fonts-ajax.min.js', __FILE__), array('jquery'));
}

add_action('admin_enqueue_scripts', 'swf_plugin_enqueue');

function swf_plugin_web_font() {
	$options = get_option('swf_options');
	$selected_weights;
	foreach($options['selected_weights'] as $weight) {
		$selected_weights .= $weight . ',';
	}
	wp_register_style('swf-web-font', 'http://fonts.googleapis.com/css?family='.urlencode($options['selected_font']).':'.substr($selected_weights, 0, -1).'', false);
	wp_enqueue_style('swf-web-font');
}

add_action('wp_enqueue_scripts', 'swf_plugin_web_font');

/************************************************************************/
/* INCLUDES
/************************************************************************/

require SWF_PATH . 'inc/simple-web-fonts-functions.inc';

?>