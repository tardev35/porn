<?php
/**
 * Theme basic setup.
 *
 * @package wpst
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

add_action( 'after_setup_theme', 'ftt_setup' );
if ( ! function_exists( 'ftt_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ftt_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on wpst, use a find and replace
		 * to change 'wpst' to the name of your theme in all the template files
		 */
		$lang = ( current( explode( '_', get_locale() ) ) );
		if ( 'zh' === $lang ) {
			$lang = 'zh-TW';
		}
		$textdomain = 'wpst';
		$mofile     = get_template_directory() . "/languages/{$textdomain}_{$lang}.mo";
		load_textdomain( $textdomain, $mofile );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'ftt-primary-menu' => __( 'Primary Menu', 'wpst' ),
				'ftt-footer-menu'  => __( 'Footer Menu', 'wpst' ),
			)
		);

		// If Main Menu exists, set it to main menu location.
		// Prevent visual issues in main menu after theme switching.
		$main_menu = wp_get_nav_menu_object( 'Main Menu' );
		if ( false !== $main_menu ) {
			$locations                     = get_theme_mod( 'nav_menu_locations' );
			$locations['ftt-primary-menu'] = $main_menu->term_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
		/*
		 * Adding Thumbnail basic support
		 */
		add_theme_support( 'post-thumbnails' );
		/*
		 * Adding support for Widget edit icons in customizer
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );
		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
			)
		);
		// Set up the WordPress core custom background feature.
		// add_theme_support( 'custom-background', apply_filters( 'ftt_custom_background_args', array(
		// 	'default-color' => 'ffffff',
		// 	'default-image' => '',
		// ) ) );
		// Set up the WordPress Theme logo feature.
		// add_theme_support( 'custom-logo' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
		// Check and setup theme default settings.
		ftt_setup_theme_default_settings();
	}
}

add_filter( 'excerpt_more', 'ftt_custom_excerpt_more' );
if ( ! function_exists( 'ftt_custom_excerpt_more' ) ) {
	/**
	 * Removes the ... from the excerpt read more link
	 *
	 * @param string $more The excerpt.
	 *
	 * @return string
	 */
	function ftt_custom_excerpt_more( $more ) {
		if ( ! is_admin() ) {
			$more = '';
		}
		return $more;
	}
}

add_filter( 'wp_trim_excerpt', 'ftt_all_excerpts_get_more_link' );
if ( ! function_exists( 'ftt_all_excerpts_get_more_link' ) ) {
	/**
	 * Adds a custom read more link to all excerpts, manually or automatically generated
	 *
	 * @param string $post_excerpt Posts's excerpt.
	 *
	 * @return string
	 */
	function ftt_all_excerpts_get_more_link( $post_excerpt ) {
		if ( ! is_admin() ) {
			$post_excerpt = $post_excerpt . ' [...]<p><a class="btn btn-primary ftt-read-more-link" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __(
				'Read More...',
				'wpst'
			) . '</a></p>';
		}
		return $post_excerpt;
	}
}
