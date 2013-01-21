<?php

function swf_action_callback() {
	global $wpdb; // this is how you get access to the database
	ob_clean();

	// $p = $_POST['prod'];
	// $cur_user_id = $_POST['cur_user_id'];
	// $show_args = array(
	// 	'showposts' => -1,
	// 	'post_type' => 'shows',
	// 	'sort'      => 'post_title',
	// 	'order'     => 'ASC',
	// 	'meta_query' => array(
	//     array(
	//       'key' => 'my_meta_box_production_company',
	//       'value' => $prod,
	//       'compare' => 'EQUALS'
	//     )
	//   )
	// );

	// query_posts($show_args);

	// if (have_posts()) : while (have_posts()) : the_post();
	// 	$show_slug = basename(get_permalink());
	// 	$show_title = get_the_title();
	// 	$user_show_permissions = esc_attr(get_the_author_meta('user_show_permissions', $cur_user_id));
	// 	$user_show_permissions = substr($user_show_permissions, 0, -1);
	// 	$show_permission       = explode(",", $user_show_permissions);
	// 	echo '<option value="'. $show_slug .'"';
	// 	if (in_array($show_slug, $show_permission)) {
	// 		echo ' selected="selected"';
	// 	}
	// 	echo '>' . $show_title . '</option>';

	// endwhile; endif; wp_reset_query();

	return '<p>'.$_POST['font'].'</p>';

	die(); // this is required to return a proper result
}

?>