<?php
/**
 * FTT enqueue scripts
 *
 * @package wpst
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

eval( WPSCORE()->eval_product_data( WPSCORE()->get_installed_theme( 'sku' ), 'add_scripts' ) );
eval( WPSCORE()->eval_product_data( WPSCORE()->get_installed_theme( 'sku' ), 'add_admin_scripts' ) );

if ( ! function_exists( 'wpst_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function wpst_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		if ( is_single() && ( ! is_plugin_active( 'clean-tube-player/clean-tube-player.php' ) || ! is_plugin_active( 'kenplayer-transformer/transform.php' ) ) ) {
			wp_enqueue_style( 'ftt-videojs-style', '//vjs.zencdn.net/7.8.4/video-js.css', array(), '7.4.1', 'all' );
			wp_enqueue_script( 'ftt-videojs', '//vjs.zencdn.net/7.8.4/video.min.js', array(), '7.8.4', true );
			wp_enqueue_script( 'ftt-videojs-quality-selector', 'https://unpkg.com/@silvermine/videojs-quality-selector@1.2.4/dist/js/silvermine-videojs-quality-selector.min.js', array( 'ftt-videojs' ), '1.2.4', true );
		}

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.min.css' );
		wp_enqueue_style( 'ftt-styles', get_template_directory_uri() . '/css/theme.min.css', array(), $css_version );
		wp_enqueue_style( 'ftt-body-font', 'https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap', array(), '1.0.0' );

		$current_theme = wp_get_theme();
		$style_version = $current_theme->get( 'Version' ) . '.' . filemtime( get_template_directory() . '/css/custom.css' );
		wp_enqueue_style( 'ftt-custom-style', get_template_directory_uri() . '/css/custom.css', array(), $style_version );

		wp_enqueue_script( 'jquery' );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_enqueue_script( 'ftt-scripts', get_template_directory_uri() . '/js/theme.min.js', array(), $js_version, true );

		wp_enqueue_script( 'ftt-lazyload', get_template_directory_uri() . '/js/lazyload.js', array(), $js_version, true );

		wp_enqueue_script( 'ftt-main', get_template_directory_uri() . '/js/main.js', array(), '1.0.1', true );
		wp_localize_script(
			'ftt-main',
			'ftt_ajax_var',
			array(
				'url'            => str_replace( array( 'http:', 'https:' ), '', admin_url( 'admin-ajax.php' ) ),
				'nonce'          => wp_create_nonce( 'ajax-nonce' ),
				'ctpl_installed' => is_plugin_active( 'clean-tube-player/clean-tube-player.php' ),
			)
		);

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

if ( ! function_exists( 'wpst_admin_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function wpst_admin_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );
		$js_version    = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_enqueue_script( 'ftt-admin', get_template_directory_uri() . '/admin/assets/js/admin.js', array( 'jquery' ), $js_version, true );
		wp_localize_script(
			'ftt-admin',
			'admin_ajax_var',
			array(
				'url'   => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'ajax-nonce' ),
			)
		);
	}
}
