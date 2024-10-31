<?php
function csqsmcleanshortcodepostcache(){
	global $post;
  global $csqsmquizshortcodename;
	if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, $csqsmquizshortcodename) ) {
	 clean_post_cache($post);


	}
}


function csqsmquizmanagercustom_shortcode_styles(){
	global $post;
  global $csqsmquizshortcodename;
	if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, $csqsmquizshortcodename) && !is_admin() ) {
		$cssquiz = plugin_dir_url( __FILE__ ) . 'css/quiz.css';
		wp_enqueue_style(
						'csqsmquiz',
						$cssquiz
		);


	}
}

function csqsmquizmanagercustom_shortcode_scripts() {
    global $post;
    global $csqsmquizshortcodename;
    if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, $csqsmquizshortcodename) && !is_admin()) {
			$jspath =  plugin_dir_url( __FILE__ ) . 'js/form.js';
			wp_register_script( 'csqsmquizform', $jspath , '', '', true );
			wp_enqueue_script( 'csqsmquizform' );



    }
}
?>
