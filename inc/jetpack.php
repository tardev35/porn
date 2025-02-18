<?php

/**

 * Jetpack Compatibility File

 *@package famoustube

 * @link https://jetpack.me/

 *

 * @package UnderStrap

 */



// Exit if accessed directly.

defined( 'ABSPATH' ) || exit;



/**

 * Jetpack setup function.

 *

 * See: https://jetpack.me/support/infinite-scroll/

 * See: https://jetpack.me/support/responsive-videos/

 */



add_action( 'after_setup_theme', 'ftt_components_jetpack_setup' );



if ( ! function_exists( 'ftt_components_jetpack_setup' ) ) {

	function ftt_components_jetpack_setup() {

		// Add theme support for Infinite Scroll.

		add_theme_support(

			'infinite-scroll',

			array(

				'container' => 'main',

				'render'    => 'ftt_components_infinite_scroll_render',

				'footer'    => 'page',

			)

		);



		// Add theme support for Responsive Videos.

		add_theme_support( 'jetpack-responsive-videos' );



		// Add theme support for Social Menus

		add_theme_support( 'jetpack-social-menu' );



	}

}





/**

 * Custom render function for Infinite Scroll.

 */



if ( ! function_exists( 'ftt_components_infinite_scroll_render' ) ) {

	function ftt_components_infinite_scroll_render() {

		if ( have_posts() ) :

			while ( have_posts() ) :

				the_post();

				if ( is_search() ) :

					get_template_part( 'loop-templates/content', 'search' );

				else :

					get_template_part( 'loop-templates/content', get_post_format() );

				endif;

			endwhile;

		endif;

	}

}



if ( ! function_exists( 'ftt_components_social_menu' ) ) {

	function ftt_components_social_menu() {

		if ( ! function_exists( 'jetpack_social_menu' ) ) {

			return;

		} else {

			jetpack_social_menu();

		}

	}

}

