<?php

/**
* Plugin Name: No Nonsense Authors List
* Plugin URI:
* Description: Displays Authors List anywhere in your wordpress blog.
* Version: 0.1 
* Author: Abhineet Mittal
* Author URI:
* License: GNU AGPL v3.0 or later
*/

// Shortcode function to display authors list
function wbs_no_nonsense_authors_list() {
	global $wpdb;
	$sc_string = '<div id="wbsauthorlist"><ul>';
	$authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users ORDER BY RAND()");

	foreach($authors as $author) {
		$sc_string .= "<li><a href=\"".get_bloginfo('url')."/author/" . get_the_author_meta('user_nicename', $author->ID) . "/\">";
		$sc_string .= get_avatar($author->ID);
		$sc_string .= "</a><div><a href=\"" . get_bloginfo('url') . "/author/" . get_the_author_meta('user_nicename', $author->ID) . "/\">";
		// If first name is empty, display the username
		if (get_the_author_meta('first_name', $author->ID) == "") {
			$authorname = get_the_author_meta('user_nicename', $author->ID);
		}
		else {
			$authorname = get_the_author_meta('first_name', $author->ID). ' ' . get_the_author_meta('last_name', $author->ID);
		}
		$sc_string .= ' ' . $authorname . '</a><br />';
		
		// Display Author bio if it is there in author bio field in profile
		if (get_the_author_meta('user_description', $author->ID) != "")
		{
			//echo '<strong>Short Introduction- </strong>';
			$sc_string .= get_the_author_meta('user_description', $author->ID);
		}			
		
		$sc_string .= "</div></li>";
	}
	$sc_string .= '</ul></div>';
	return $sc_string;
}
// Registering the above shortcode
add_shortcode('NO_NONSENSE_AUTHORS_LIST', 'wbs_no_nonsense_authors_list');

// Hook for header
add_action('wp_head','wbs_header_author_style_code');

function wbs_header_author_style_code() { 
?>

	<style>

	#wbsauthorlist ul{
	list-style: none;
	max-width: 100%;
	margin: 0;
	padding: 0;
	}
	#wbsauthorlist li {
	clear:left;
	margin: 0 0 5px 0;
	list-style: none;
	min-height: 100px;
	padding: 15px 0 15px 0;
	border-bottom: 1px solid #ececec;
	}
	#wbsauthorlist img.photo {
	width: 80px;
	height: 80px;
	float: left;
	margin: 0 15px 0 0;
	padding: 3px;
	border: 1px solid #ececec;
	}
	#wbsauthorlist div.authname {
	margin: 20px 0 0 10px;
	}
	</style>

<?php
}
?>