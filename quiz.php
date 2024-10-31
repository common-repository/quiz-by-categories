<?php
/*
Plugin Name: Quiz By Categories
Plugin URI: https://moduloinfo.ca/wordpress/
Description: This plugin manage a quiz system that permit you to submit a user to different quiz questions separated into category
Author: Carl Sansfacon
Text Domain: quiz-by-categories
Domain Path: /languages
Version: 1.0
Author URI: https://moduloinfo.ca/
Requires at least: 4.6

*/
$csqsmquizshortcodename = "singlequiz";

include_once 'usersmanagement.php';
add_action('wp_loaded', 'csqsmsetcookietoken');

include_once 'databasemanagement.php';
register_activation_hook( __FILE__, 'csqsmmy_plugin_create_db' );

// Mother of all
function csqsmquizmanager($atts = [], $content = null, $tag = '') {
	if(!is_admin()){
  // normalize attribute keys, lowercase
  $atts = array_change_key_case((array)$atts, CASE_LOWER);
  // override default attributes with user attributes
  $wporg_atts = shortcode_atts([
                                       'quizformtype' => 'default',
                                   ], $atts, $tag);

  ob_start();
	include_once  plugin_dir_path( __FILE__ ) . 'quizshortcode.php';
	$string = ob_get_clean();
	return $string;
	}
return "";
}

add_shortcode($csqsmquizshortcodename, 'csqsmquizmanager');

include_once 'enqueueassets.php';
add_action( 'get_header', 'csqsmquizmanagercustom_shortcode_styles' );
add_action( 'get_header', 'csqsmquizmanagercustom_shortcode_scripts' );

function csqsmmy_plugin_load_plugin_textdomain() {
    load_plugin_textdomain( 'quiz-by-categories', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'csqsmmy_plugin_load_plugin_textdomain' );





?>
