<?php
/**
 * @package famoustubeme's default settings
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'ftt_setup_theme_default_settings' ) ) {
	function ftt_setup_theme_default_settings() {

		// check if settings are set, if not set defaults.
		// Caution: DO NOT check existence using === always check with == .
		// Latest blog posts style.
		$ftt_posts_index_style = get_theme_mod( 'ftt_posts_index_style' );
		if ( '' == $ftt_posts_index_style ) {
			set_theme_mod( 'ftt_posts_index_style', 'default' );
		}

		// Sidebar position.
		$ftt_sidebar_position = get_theme_mod( 'ftt_sidebar_position' );
		if ( '' == $ftt_sidebar_position ) {
			set_theme_mod( 'ftt_sidebar_position', 'left' );
		}

		// Container width.
		// $ftt_container_type = get_theme_mod( 'ftt_container_type' );
		// if ( '' == $ftt_container_type ) {
		// 	set_theme_mod( 'ftt_container_type', 'container' );
		// }
	}
}
