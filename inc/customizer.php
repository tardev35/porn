<?php
/**
 * FTT Theme Customizer
 *
 * @package wpst
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'ftt_customize_register' ) ) {
	/**
	 * Register basic customizer support.
	 *
	 * @param object $wp_customize Customizer reference.
	 */
	function ftt_customize_register( $wp_customize ) {
		$wp_customize->remove_section( 'title_tagline' );
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'static_front_page' );
		$wp_customize->remove_section( 'background_image' );
	}
}
add_action( 'customize_register', 'ftt_customize_register' );

if ( ! function_exists( 'ftt_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function ftt_theme_customize_register( $wp_customize ) {
		/*********************************/
		/****** NEW SECTION GENERAL ******/
		/*********************************/
		$wp_customize->add_section(
			'ftt_general',
			array(
				'title'    => __( 'General', 'wpst' ),
				'priority' => 10,
			)
		);

		// Link color.
		$wp_customize->add_setting(
			'main_color',
			array(
				'default'   => '#ff9900',
				'transport' => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'ftt_main_color',
				array(
					'label'    => __( 'Main Color', 'wpst' ),
					'section'  => 'ftt_general',
					'settings' => 'main_color',
				)
			)
		);

		// Recently added videos number
		$wp_customize->add_setting(
			'recently_added_videos_number',
			array(
				'default'   => 36,
				'sanitize_callback' => 'ftt_sanitize_number_absint',
				'transport' => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_recently_added_videos_number',
				array(
					'label'    => __( 'Recently added videos number', 'wpst' ),
					'section'  => 'ftt_general',
					'settings' => 'recently_added_videos_number',
					'type'	   => 'number',
					'input_attrs' => array(
						'min' => 12,
						'max' => 60,
						'step' => 1,
					),				
				)
			)
		);

		/******************************/
		/****** NEW SECTION LOGO ******/
		/******************************/
		$wp_customize->add_section(
			'ftt_logo',
			array(
				'title'    => __( 'Logo & Favicon', 'wpst' ),
				'priority' => 20,
			)
		);

		$wp_customize->add_setting(
			'logo_file',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'ftt_logo_file',
				array(
					'label'    => __( 'Upload a logo image', 'theme_name' ),
					'section'  => 'ftt_logo',
					'settings' => 'logo_file',
				)
			)
		);

		$wp_customize->add_setting(
			'logo_sep',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new Customizer_Library_Help_Text(
				$wp_customize,
				'ftt_logo_sep',
				array(
					'label'       => __( 'Or build your own tube logo online:', 'theme_name' ),
					'section'     => 'ftt_logo',
					'description' => '',
					'settings'    => 'logo_sep',
				)
			)
		);

		// Logo Word 1.
		$wp_customize->add_setting(
			'logo_word_1',
			array(
				'default'   => 'Your',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_logo_word_1',
				array(
					'label'    => __( 'Word 1', 'wpst' ),
					'section'  => 'ftt_logo',
					'settings' => 'logo_word_1',
					'type'     => 'text',
				)
			)
		);

		// Logo Word 2.
		$wp_customize->add_setting(
			'logo_word_2',
			array(
				'default'   => 'logo',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_logo_word_2',
				array(
					'label'    => __( 'Word 2', 'wpst' ),
					'section'  => 'ftt_logo',
					'settings' => 'logo_word_2',
					'type'     => 'text',
				)
			)
		);

		$wp_customize->add_setting(
			'favicon_file',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'ftt_favicon_file',
				array(
					'label'       => __( 'Upload a favicon image', 'theme_name' ),
					'section'     => 'ftt_logo',
					'settings'    => 'favicon_file',
					'description' => 'png or ico - 32x32',
				)
			)
		);

		/*************************************/
		/****** NEW SECTION ADVERTISING ******/
		/*************************************/
		$wp_customize->add_panel(
			'ftt_ads',
			array(
				'capability'     => 'edit_theme_options',
				'priority'       => 50,
				'theme_supports' => '',
				'title'          => __( 'Advertising', 'wpst' ),
				'description'    => __( 'Settings to add ads into your site', 'wpst' ),
			)
		);

		/**
		 * HOME ADS
		 */
		$wp_customize->add_section(
			'ftt_ads_home',
			array(
				'priority'       => 50,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Homepage', 'wpst' ),
				'description'    => __( 'Add your own ads on the homepage.', 'wpst' ),
				'panel'          => 'ftt_ads',
			)
		);

		// Home Ad inside videos list.
		$wp_customize->add_setting(
			'ads_home_inside_list',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_home_inside_list',
				array(
					'label'    => esc_html__( 'Ad zone inside videos list', 'wpst' ),
					'section'  => 'ftt_ads_home',
					'settings' => 'ads_home_inside_list',
					'type'     => 'textarea',
				)
			)
		);

		// Home Ad page bottom.
		$wp_customize->add_setting(
			'ads_home_page_bottom',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-4.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_home_page_bottom',
				array(
					'label'    => esc_html__( 'Ad zone at the bottom of the page', 'wpst' ),
					'section'  => 'ftt_ads_home',
					'settings' => 'ads_home_page_bottom',
					'type'     => 'textarea',
				)
			)
		);

		/**
		 * SINGLE VIDEO PAGE ADS
		 */
		$wp_customize->add_section(
			'ftt_ads_single_video_page',
			array(
				'priority'       => 50,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Single Video Page', 'wpst' ),
				'description'    => __( 'Add your own ads on single video pages.', 'wpst' ),
				'panel'          => 'ftt_ads',
			)
		);

		// Single video page Ad in player 1.
		$wp_customize->add_setting(
			'ads_single_video_page_in_player_1',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_single_video_page_in_player_1',
				array(
					'label'    => esc_html__( 'In player ad zone 1', 'wpst' ),
					'section'  => 'ftt_ads_single_video_page',
					'settings' => 'ads_single_video_page_in_player_1',
					'type'     => 'textarea',
				)
			)
		);

		// Single video page Ad in player 2.
		$wp_customize->add_setting(
			'ads_single_video_page_in_player_2',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_single_video_page_in_player_2',
				array(
					'label'    => esc_html__( 'In player ad zone 2', 'wpst' ),
					'section'  => 'ftt_ads_single_video_page',
					'settings' => 'ads_single_video_page_in_player_2',
					'type'     => 'textarea',
				)
			)
		);

		// Single video page Ad under player.
		$wp_customize->add_setting(
			'ads_single_video_page_under_player',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-3.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_single_video_page_under_player',
				array(
					'label'    => esc_html__( 'Under player ad zone', 'wpst' ),
					'section'  => 'ftt_ads_single_video_page',
					'settings' => 'ads_single_video_page_under_player',
					'type'     => 'textarea',
				)
			)
		);

		// Single video page Ad beside player 1.
		$wp_customize->add_setting(
			'ads_single_video_page_beside_player_1',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_single_video_page_beside_player_1',
				array(
					'label'    => esc_html__( 'Beside player ad zone 1', 'wpst' ),
					'section'  => 'ftt_ads_single_video_page',
					'settings' => 'ads_single_video_page_beside_player_1',
					'type'     => 'textarea',
				)
			)
		);

		// Single video page Ad beside player 2.
		$wp_customize->add_setting(
			'ads_single_video_page_beside_player_2',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_single_video_page_beside_player_2',
				array(
					'label'    => esc_html__( 'Beside player ad zone 2', 'wpst' ),
					'section'  => 'ftt_ads_single_video_page',
					'settings' => 'ads_single_video_page_beside_player_2',
					'type'     => 'textarea',
				)
			)
		);

		// Single video page bottom ad.
		$wp_customize->add_setting(
			'ads_single_video_page_bottom',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-4.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_single_video_page_bottom',
				array(
					'label'    => esc_html__( 'Ad zone at the bottom of the page', 'wpst' ),
					'section'  => 'ftt_ads_single_video_page',
					'settings' => 'ads_single_video_page_bottom',
					'type'     => 'textarea',
				)
			)
		);

		/**
		 * CATEGORY PAGE ADS
		 */
		$wp_customize->add_section(
			'ftt_ads_category_page',
			array(
				'priority'       => 50,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Category Page', 'wpst' ),
				'description'    => __( 'Add your own ads on the Category pages.', 'wpst' ),
				'panel'          => 'ftt_ads',
			)
		);

		// Category page Ad inside videos list.
		$wp_customize->add_setting(
			'ads_category_page_inside_list',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_category_page_inside_list',
				array(
					'label'    => esc_html__( 'Ad zone inside videos list', 'wpst' ),
					'section'  => 'ftt_ads_category_page',
					'settings' => 'ads_category_page_inside_list',
					'type'     => 'textarea',
				)
			)
		);

		// Category page bottom ad.
		$wp_customize->add_setting(
			'ads_category_page_bottom',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-4.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_category_page_bottom',
				array(
					'label'    => esc_html__( 'Ad zone at the bottom of the page', 'wpst' ),
					'section'  => 'ftt_ads_category_page',
					'settings' => 'ads_category_page_bottom',
					'type'     => 'textarea',
				)
			)
		);

		/**
		 * TAG PAGE ADS
		 */
		$wp_customize->add_section(
			'ftt_ads_tag_page',
			array(
				'priority'       => 50,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Tag Page', 'wpst' ),
				'description'    => __( 'Add your own ads on the Tag pages.', 'wpst' ),
				'panel'          => 'ftt_ads',
			)
		);

		// Tag page Ad inside videos list.
		$wp_customize->add_setting(
			'ads_tag_page_inside_list',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_tag_page_inside_list',
				array(
					'label'    => esc_html__( 'Ad zone inside videos list', 'wpst' ),
					'section'  => 'ftt_ads_tag_page',
					'settings' => 'ads_tag_page_inside_list',
					'type'     => 'textarea',
				)
			)
		);

		// Tag page bottom ad.
		$wp_customize->add_setting(
			'ads_tag_page_bottom',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-4.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_tag_page_bottom',
				array(
					'label'    => esc_html__( 'Ad zone at the bottom of the page', 'wpst' ),
					'section'  => 'ftt_ads_tag_page',
					'settings' => 'ads_tag_page_bottom',
					'type'     => 'textarea',
				)
			)
		);

		/**
		 * ACTOR PAGE ADS
		 */
		$wp_customize->add_section(
			'ftt_ads_actor_page',
			array(
				'priority'       => 50,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Actor Page', 'wpst' ),
				'description'    => __( 'Add your own ads on the actor pages.', 'wpst' ),
				'panel'          => 'ftt_ads',
			)
		);

		// actor page Ad inside videos list.
		$wp_customize->add_setting(
			'ads_actor_page_inside_list',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_actor_page_inside_list',
				array(
					'label'    => esc_html__( 'Ad zone inside videos list', 'wpst' ),
					'section'  => 'ftt_ads_actor_page',
					'settings' => 'ads_actor_page_inside_list',
					'type'     => 'textarea',
				)
			)
		);

		// actor page bottom ad.
		$wp_customize->add_setting(
			'ads_actor_page_bottom',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-4.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_actor_page_bottom',
				array(
					'label'    => esc_html__( 'Ad zone at the bottom of the page', 'wpst' ),
					'section'  => 'ftt_ads_actor_page',
					'settings' => 'ads_actor_page_bottom',
					'type'     => 'textarea',
				)
			)
		);

		/**
		 * AUTHOR PAGE ADS
		 */
		$wp_customize->add_section(
			'ftt_ads_author_page',
			array(
				'priority'       => 50,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Author Page', 'wpst' ),
				'description'    => __( 'Add your own ads on the author pages.', 'wpst' ),
				'panel'          => 'ftt_ads',
			)
		);

		// Author page Ad inside videos list.
		$wp_customize->add_setting(
			'ads_author_page_inside_list',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_author_page_inside_list',
				array(
					'label'    => esc_html__( 'Ad zone inside videos list', 'wpst' ),
					'section'  => 'ftt_ads_author_page',
					'settings' => 'ads_author_page_inside_list',
					'type'     => 'textarea',
				)
			)
		);

		// Author page bottom ad.
		$wp_customize->add_setting(
			'ads_author_page_bottom',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-4.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_author_page_bottom',
				array(
					'label'    => esc_html__( 'Ad zone at the bottom of the page', 'wpst' ),
					'section'  => 'ftt_ads_author_page',
					'settings' => 'ads_author_page_bottom',
					'type'     => 'textarea',
				)
			)
		);

		/**
		 * SEARCH RESULT PAGE ADS
		 */
		$wp_customize->add_section(
			'ftt_ads_search_result_page',
			array(
				'priority'       => 50,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Search Result Page', 'wpst' ),
				'description'    => __( 'Add your own ads on the search result pages.', 'wpst' ),
				'panel'          => 'ftt_ads',
			)
		);

		// Search result page Ad inside videos list.
		$wp_customize->add_setting(
			'ads_search_result_page_inside_list',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_search_result_page_inside_list',
				array(
					'label'    => esc_html__( 'Ad zone inside videos list', 'wpst' ),
					'section'  => 'ftt_ads_search_result_page',
					'settings' => 'ads_search_result_page_inside_list',
					'type'     => 'textarea',
				)
			)
		);

		// Search result page bottom ad.
		$wp_customize->add_setting(
			'ads_search_result_page_bottom',
			array(
				'default'   => '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-4.png"></a>',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_ads_search_result_page_bottom',
				array(
					'label'    => esc_html__( 'Ad zone at the bottom of the page', 'wpst' ),
					'section'  => 'ftt_ads_search_result_page',
					'settings' => 'ads_search_result_page_bottom',
					'type'     => 'textarea',
				)
			)
		);

		/*****************************/
		/****** NEW SECTION SEO ******/
		/*****************************/
		$wp_customize->add_panel(
			'ftt_seo',
			array(
				'priority'       => 60,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'SEO', 'wpst' ),
				'description'    => __( 'Several settings pertaining my theme', 'wpst' ),
			)
		);

		/**
		 * HOME
		 */
		$wp_customize->add_section(
			'ftt_seo_home',
			array(
				'priority'       => 60,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Homepage', 'wpst' ),
				'description'    => __( 'Rewrite content on homepage to improve SEO.', 'wpst' ),
				'panel'          => 'ftt_seo',
			)
		);

		// HOME SEO Title.
		$wp_customize->add_setting(
			'seo_home_title',
			array(
				'default'   => get_bloginfo( 'description' ),
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_seo_home_title',
				array(
					'label'    => __( 'Home Title', 'wpst' ),
					'section'  => 'ftt_seo_home',
					'settings' => 'seo_home_title',
					'type'     => 'text',
				)
			)
		);
		// HOME SEO Description.
		$wp_customize->add_setting(
			'seo_home_description',
			array(
				'default'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new Text_Editor_Custom_Control(
				$wp_customize,
				'ftt_seo_home_description',
				array(
					'label'    => __( 'Home Description', 'wpst' ),
					'section'  => 'ftt_seo_home',
					'settings' => 'seo_home_description',
					'type'     => 'textarea',
				)
			)
		);

		/**
		 * CAT
		 */
		$wp_customize->add_section(
			'ftt_seo_video_cat',
			array(
				'priority'       => 60,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Category pages', 'wpst' ),
				'description'    => __( 'Rewrite content on category pages to improve SEO.', 'wpst' ) . ftt_add_variables(
					array(
						'%%cat%%' => __( 'display category name.', 'wpst' ),
					)
				),
				'panel'          => 'ftt_seo',
			)
		);

		// CAT SEO Title.
		$wp_customize->add_setting(
			'seo_video_cat_title',
			array(
				'default'   => '%%cat%% porn videos',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_seo_video_cat_title',
				array(
					'label'    => __( 'Category Title', 'wpst' ),
					'section'  => 'ftt_seo_video_cat',
					'settings' => 'seo_video_cat_title',
					'type'     => 'text',
				)
			)
		);
		// CAT SEO Description.
		$wp_customize->add_setting(
			'seo_video_cat_description',
			array(
				'default'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new Text_Editor_Custom_Control(
				$wp_customize,
				'ftt_seo_video_cat_description',
				array(
					'label'    => __( 'Category Description', 'wpst' ),
					'section'  => 'ftt_seo_video_cat',
					'settings' => 'seo_video_cat_description',
					'type'     => 'textarea',
				)
			)
		);

		/**
		 * TAG
		 */
		$wp_customize->add_section(
			'ftt_seo_video_tag',
			array(
				'priority'       => 60,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Tag pages', 'wpst' ),
				'description'    => __( 'Rewrite content on tag pages to improve SEO.', 'wpst' ) . ftt_add_variables(
					array(
						'%%tag%%' => __( 'display tag name.', 'wpst' ),
					)
				),
				'panel'          => 'ftt_seo',
			)
		);

		// TAG SEO Title.
		$wp_customize->add_setting(
			'seo_video_tag_title',
			array(
				'default'   => '%%tag%% porn videos',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_seo_video_tag_title',
				array(
					'label'    => __( 'Tag Title', 'wpst' ),
					'section'  => 'ftt_seo_video_tag',
					'settings' => 'seo_video_tag_title',
					'type'     => 'text',
				)
			)
		);
		// TAG SEO Description.
		$wp_customize->add_setting(
			'seo_video_tag_description',
			array(
				'default'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new Text_Editor_Custom_Control(
				$wp_customize,
				'ftt_seo_video_tag_description',
				array(
					'label'    => __( 'Tag Description', 'wpst' ),
					'section'  => 'ftt_seo_video_tag',
					'settings' => 'seo_video_tag_description',
					'type'     => 'textarea',
				)
			)
		);

		/**
		 * ACTOR
		 */
		$wp_customize->add_section(
			'ftt_seo_video_actor',
			array(
				'priority'       => 60,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Actor pages', 'wpst' ),
				'description'    => __( 'Rewrite content on actor pages to improve SEO.', 'wpst' ) . ftt_add_variables(
					array(
						'%%cat%%' => __( 'display actor name.', 'wpst' ),
					)
				),
				'panel'          => 'ftt_seo',
			)
		);

		// ACTOR SEO Title.
		$wp_customize->add_setting(
			'seo_video_actor_title',
			array(
				'default'   => '%%actor%% porn videos',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_seo_video_actor_title',
				array(
					'label'    => __( 'Actor Title', 'wpst' ),
					'section'  => 'ftt_seo_video_actor',
					'settings' => 'seo_video_actor_title',
					'type'     => 'text',
				)
			)
		);
		// ACTOR SEO Description.
		$wp_customize->add_setting(
			'seo_video_actor_description',
			array(
				'default'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new Text_Editor_Custom_Control(
				$wp_customize,
				'ftt_seo_video_actor_description',
				array(
					'label'    => __( 'Actor Description', 'wpst' ),
					'section'  => 'ftt_seo_video_actor',
					'settings' => 'seo_video_actor_description',
					'type'     => 'textarea',
				)
			)
		);

		/**
		 * SEARCH
		 */
		$wp_customize->add_section(
			'ftt_seo_search',
			array(
				'priority'       => 60,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Search result pages', 'wpst' ),
				'description'    => __( 'Rewrite content on search result pages.', 'wpst' ) . ftt_add_variables(
					array(
						'%%search_tag%%'    => __( 'display search tag name.', 'wpst' ),
						'%%search_number%%' => __( 'display search result number.', 'wpst' ),
					)
				),
				'panel'          => 'ftt_seo',
			)
		);

		// SEARCH SEO Title.
		$wp_customize->add_setting(
			'seo_search_title',
			array(
				'default'   => '%%search_number%% videos found with %%search_tag%%',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_seo_search_title',
				array(
					'label'    => __( 'Search Title', 'wpst' ),
					'section'  => 'ftt_seo_search',
					'settings' => 'seo_search_title',
					'type'     => 'text',
				)
			)
		);

		// SEARCH SEO Description.
		$wp_customize->add_setting(
			'seo_search_description',
			array(
				'default'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new Text_Editor_Custom_Control(
				$wp_customize,
				'ftt_seo_search_description',
				array(
					'label'    => __( 'Search Description', 'wpst' ),
					'section'  => 'ftt_seo_search',
					'settings' => 'seo_search_description',
					'type'     => 'textarea',
				)
			)
		);

		/***********************************/
		/****** NEW SECTION COPYRIGHT ******/
		/***********************************/
		$wp_customize->add_section(
			'ftt_copyright',
			array(
				'title'    => __( 'Copyright', 'wpst' ),
				'priority' => 70,
			)
		);

		// Copyright Text.
		$wp_customize->add_setting(
			'copyright_content',
			array(
				'default'   => gmdate( 'Y' ) . ' - ' . get_bloginfo( 'name' ) . '. ' . esc_html__( 'All rights reserved. Powered by WP-Script.com', 'wpst' ),
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new Text_Editor_Custom_Control(
				$wp_customize,
				'ftt_copyright_content',
				array(
					'label'    => __( 'Content', 'wpst' ),
					'section'  => 'ftt_copyright',
					'settings' => 'copyright_content',
					'type'     => 'textarea',
				)
			)
		);

		/*********************************/
		/****** NEW SECTION SCRIPTS ******/
		/*********************************/
		$wp_customize->add_section(
			'ftt_scripts_section',
			array(
				'title'    => __( 'Scripts', 'wpst' ),
				'priority' => 80,
			)
		);

		// Google Analytics.
		$wp_customize->add_setting(
			'google_analytics_code',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_google_analytics_code',
				array(
					'label'       => esc_html__( 'Google Analytics', 'wpst' ),
					'section'     => 'ftt_scripts_section',
					'settings'    => 'google_analytics_code',
					'type'        => 'textarea',
					'description' => __( 'Paste here your Google Analytics tracking code.', 'wpst' ),
				)
			)
		);

		// Meta verification.
		$wp_customize->add_setting(
			'meta_verification_code',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_meta_verification_code',
				array(
					'label'       => esc_html__( 'Meta Verification', 'wpst' ),
					'section'     => 'ftt_scripts_section',
					'settings'    => 'meta_verification_code',
					'type'        => 'textarea',
					'description' => __( 'Paste here meta codes for domain verification.', 'wpst' )
				)
			)
		);

		// Other scripts.
		$wp_customize->add_setting(
			'other_script_codes',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ftt_other_script_codes',
				array(
					'label'       => esc_html__( 'Other scripts', 'wpst' ),
					'section'     => 'ftt_scripts_section',
					'settings'    => 'other_script_codes',
					'type'        => 'textarea',
					'description' => __( 'Paste here your other scripts (eg. popunder script)', 'wpst' ),
				)
			)
		);
	}
}
add_action( 'customize_register', 'ftt_theme_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists( 'ftt_customize_preview_js' ) ) {
	/**
	 * Setup JS integration for live previewing.
	 */
	function ftt_customize_preview_js() {
		wp_enqueue_script(
			'ftt_customizer',
			get_template_directory_uri() . '/js/customizer.js',
			array( 'customize-preview' ),
			'1.0.5',
			true
		);
	}
}
// add_action( 'customize_preview_init', 'ftt_customize_preview_js' );

function ftt_customize_css() {
	$main_color = get_theme_mod( 'main_color', '#ff9900' );
	?>
	<style type="text/css">
		.logo-word-2,
		.header-search #searchsubmit,
		.video-block .video-debounce-bar,
		.hamburger-inner, .hamburger-inner::before, .hamburger-inner::after {
			background-color: <?php echo $main_color; ?>;
		}
		a,
		a:hover,
		ul#menu-footer-menu li a:hover,
		.required,
		#show-sharing-buttons:hover i,
		.tags-letter-block .tag-items .tag-item a:hover,
		.post-like a:hover i {
			color: <?php echo $main_color; ?>;
		}
		.pagination-lg .page-item:first-child .page-link,
		.pagination-lg .page-item:last-child .page-link {
			border-color: <?php echo $main_color; ?>!important;
			color: <?php echo $main_color; ?>;
		}
		.navbar li.active a,
		#video-tabs button.tab-link.active,
		#video-tabs button.tab-link:hover {
			border-bottom-color: <?php echo $main_color; ?>!important;
		}
		.btn,
		.btn-primary,
		.post-navigation a,
		.btn:hover {
			background-color: <?php echo $main_color; ?>!important;
			color: <?php echo ftt_get_brightness( $main_color, '#FFFFFF', '#000000' ); ?>!important;
			border-color: <?php echo $main_color; ?>!important;
		}
		.page-item.active .page-link {
			background-color: <?php echo $main_color; ?>!important;
			border-color: <?php echo $main_color; ?>!important;
			color: <?php echo ftt_get_brightness( $main_color, '#FFFFFF', '#000000' ); ?>!important;
		}
		@-webkit-keyframes glowing {
			0% { border-color: <?php echo $main_color; ?>; -webkit-box-shadow: 0 0 3px <?php echo $main_color; ?>; }
			50% { -webkit-box-shadow: 0 0 20px <?php echo $main_color; ?>; }
			100% { border-color: <?php echo $main_color; ?>; -webkit-box-shadow: 0 0 3px <?php echo $main_color; ?>; }
		}

		@-moz-keyframes glowing {
			0% { border-color: <?php echo $main_color; ?>; -moz-box-shadow: 0 0 3px <?php echo $main_color; ?>; }
			50% { -moz-box-shadow: 0 0 20px <?php echo $main_color; ?>; }
			100% { border-color: <?php echo $main_color; ?>; -moz-box-shadow: 0 0 3px <?php echo $main_color; ?>; }
		}

		@-o-keyframes glowing {
			0% { border-color: <?php echo $main_color; ?>; box-shadow: 0 0 3px <?php echo $main_color; ?>; }
			50% { box-shadow: 0 0 20px <?php echo $main_color; ?>; }
			100% { border-color: <?php echo $main_color; ?>; box-shadow: 0 0 3px <?php echo $main_color; ?>; }
		}

		@keyframes glowing {
			0% { border-color: <?php echo $main_color; ?>; box-shadow: 0 0 3px <?php echo $main_color; ?>; }
			50% { box-shadow: 0 0 20px <?php echo $main_color; ?>; }
			100% { border-color: <?php echo $main_color; ?>; box-shadow: 0 0 3px <?php echo $main_color; ?>; }
		}

	</style>
	<?php
}
add_action( 'wp_head', 'ftt_customize_css' );

function ftt_get_brightness( $hex, $light_color, $dark_color ) {
	$hex = str_replace( '#', '', $hex );
	$c_r = hexdec( substr( $hex, 0, 2 ) );
	$c_g = hexdec( substr( $hex, 2, 2 ) );
	$c_b = hexdec( substr( $hex, 4, 2 ) );
	return ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000 > 100 ? $dark_color : $light_color;
}


function ftt_hex2rgba( $color, $opacity = false ) {
	$default = 'rgb(0,0,0)';
	if ( empty( $color ) ) {
		return $default;
	}
	if ( '#' === $color[0] ) {
		$color = substr( $color, 1 );
	}
	if ( 6 === strlen( $color ) ) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( 3 === strlen( $color ) ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}
	$rgb = array_map( 'hexdec', $hex );
	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}
		$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ',', $rgb ) . ')';
	}
	return $output;
}


function ftt_add_variables( $variables ) {
	$output  = '<p style="margin: 10px 0;">Available variable:</p>';
	$output .= '<ul style="padding: 0; margin: 0;">';
	foreach ( $variables as $key => $description ) {
		$output .= '<li style="list-style: none;"><code>' . $key . '</code>: ' . $description . '</li>';
	}
	$output .= '</ul>';
	return $output;
}


/**
 * Custom control for arbitarty text, extend the WP customizer
 */
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

class Customizer_Library_Help_Text extends WP_Customize_Control {
	/**
	 * Render the control's content.
	 */
	public function render_content() {
		echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
		echo '<p class="description">' . $this->description . '</p>';
		echo '<hr />';
	}
}

function ftt_sanitize_number_absint( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );
	// If the input is an absolute integer, return it; otherwise, return the default.
	return ( $number ? $number : $setting->default );
}
