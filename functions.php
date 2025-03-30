<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

require get_template_directory() . '/inc/theme-activation.php';

/**
 * WP-Script Core required.
 */
if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
if ( ! is_plugin_active( 'wp-script-core/wp-script-core.php' ) ) {
	require_once get_template_directory() . '/tgmpa/class-tgm-plugin-activation.php';
	require_once get_template_directory() . '/tgmpa/config.php';
}

if ( ! function_exists( 'WPSCORE' ) ) {
	return;
}

add_action( 'widgets_init', 'ftt_widgets_init' );
function display_video_tags_shortcode() {
    $tags = get_terms(array(
        'taxonomy' => 'post_tag', // Replace 'video_tag' with the correct taxonomy for video tags if different
        'hide_empty' => false,
    ));

    if (!empty($tags) && !is_wp_error($tags)) {
        $output = '<div class="video-tags-shortcode"><ul>';
        foreach ($tags as $tag) {
            $output .= '<li><a href="' . get_term_link($tag) . '">' . esc_html($tag->name) . '</a></li>';
        }
        $output .= '</ul></div>';
    } else {
        $output = '<p>No tags found.</p>';
    }

    return $output;
}
add_shortcode('video_tags', 'display_video_tags_shortcode');

function display_video_cat_shortcode() {
    // Retrieve all terms from the 'category' taxonomy
    $cats = get_terms(array(
        'taxonomy' => 'category', 
        'hide_empty' => false,    
    ));

    // Fetch all term images for categories
    $term_images = apply_filters('taxonomy-images-get-terms', '');
	
    if (!empty($cats) && !is_wp_error($cats)) {
        $output = '<ul class="card-container">';  // Start the list

        foreach ($cats as $cat) {
            $image_html = ''; 

            // Loop through term images to find the image for the current category
            if (!empty($term_images)) {
                foreach ($term_images as $term_image) {
                    if ($term_image->term_id == $cat->term_id) {
                        // Fetch a higher resolution image (using 'large' or custom size)
                        $image_html = '<a href="' . esc_url(get_term_link($cat)) . '">'
                                    . wp_get_attachment_image($term_image->image_id, 'large') // Change 'detail' to 'large' or 'full'
                                    . '</a>';
                        break;
                    }
                }
            }

            $output .= '<li class="card">';

            if (!empty($image_html)) {
                $output .= $image_html;
            }

            $output .= '<div class="card-body">';
            //$output .= '<a href="' . esc_url(get_term_link($cat)) . '"><h3>' . esc_html($cat->name) . '</h3></a>';

            if (!empty($cat->description)) {
                $output .= '<a href="' . esc_url(get_term_link($cat)) . '"><h2 style="color:black;">' . esc_html($cat->description) . '</h2></a>';
            }

            $output .= '</div></li>';  // Close list item
        }

        $output .= '</ul>';  // Close the list
    } else {
        $output = '<p>No categories found.</p>';
    }

    return $output;
}

add_shortcode('video_cats', 'display_video_cat_shortcode');


function display_video_actor_shortcode() {
    // Retrieve all terms from the 'actoregory' taxonomy
    $actors = get_terms(array(
        'taxonomy' => 'actors', 
        'hide_empty' => false,    
    ));
	//echo "<pre>"; print_r($actors); echo "</pre>";
    $term_images = apply_filters('taxonomy-images-get-terms', '');
	
    if (!empty($actors) && !is_wp_error($actors)) {
        $output = '<ul class="card-container">';  // Start the list
		
        foreach ($actors as $actor) {
            $image_html = ''; 

            if (!empty($term_images)) {
                foreach ($term_images as $term_image) {
                    if ($term_image->term_id == $actor->term_id) {
                        $image_html = '<a href="' . esc_url(get_term_link($actor)) . '">'
                                    . wp_get_attachment_image($term_image->image_id, 'detail')
                                    . '</a>';
                        break;
                    }
                }
            }

            $output .= '<li class="card">';

            if (!empty($image_html)) {
                $output .= $image_html;
            }

            $output .= '<div class="card-body">';
            $output .= '<a href="' . esc_url(get_term_link($actor)) . '"><h3>' . esc_html($actor->name) . '</h3></a>';

            if (!empty($actor->description)) {
                $output .= '<p>' . esc_html($actor->description) . '</p>';
            }

            $output .= '</div></li>';  // Close list item
        }

        $output .= '</ul>';  // Close the list
    } else {
        $output = '<p>No actoregories found.</p>';
    }

    return $output;
}

add_shortcode('video_actors', 'display_video_actor_shortcode');
// Load inc files.
$ftt_includes = array(
	'/filters/the-content.php',             // Filters for the_content.
	'/customizer.php',                      // Customizer additions.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/post-like.php',                       // Post like
	'/video-functions.php',                 // Video functions.
	'/actors.php',                          // Actors CPT
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/category-image.php',                  // Category image upload feature.
	'/actor-image.php',                     // Actor image upload feature.
	'/pagination.php',                      // Custom pagination for this theme.
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/widget-video.php',                    // Load widget video blocks.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/custom-comments.php',                 // Custom Comments file.
	'/jetpack.php',                         // Load Jetpack compatibility file.
	'/woocommerce.php',                     // Load WooCommerce functions.
	'/editor.php',                          // Load Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
);
foreach ( $ftt_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( $filepath ) {
		require_once $filepath;
	}
}

// Load ajax files.
$ftt_ajax = array(
	'/load-video-preview.php',
	'/login-register.php',
	'/post-like.php',
	'/post-views.php',
	'/ajax-get-async-post-data.php',
);
foreach ( $ftt_ajax as $file ) {
	$filepath = locate_template( 'ajax' . $file );
	if ( $filepath ) {
		require_once $filepath;
	}
}

// Load admin files.
$ftt_admin = array(
	'/options.php',                         // Options
	'/metabox.php',                         // Video information metabox
);
foreach ( $ftt_admin as $file ) {
	$filepath = locate_template( 'admin' . $file );
	if ( $filepath ) {
		require_once $filepath;
	}
}

// Customizer text editor.
if ( class_exists( 'WP_Customize_Control' ) ) {
	class Text_Editor_Custom_Control extends WP_Customize_Control {
		public $type = 'textarea';
		// Render the content on the theme customizer page
		public function render_content() {
			echo '<label>';
			echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
			$settings = array(
				'media_buttons' => false,
				'quicktags'     => false,
			);
			$this->filter_editor_setting_link();
			wp_editor( $this->value(), $this->id, $settings );
			echo '</label>';

			do_action( 'admin_footer' );
			do_action( 'admin_print_footer_scripts' );
		}
		private function filter_editor_setting_link() {
			add_filter( 'the_editor', array( $this, 'filter_editor_setting_link_callback' ) );
		}
		public function filter_editor_setting_link_callback( $output ) {
			return preg_replace( '/<textarea/', '<textarea ' . $this->get_link(), $output, 1 );
		}
	}
}

function ftt_editor_customizer_script() {
	wp_enqueue_script( 'wp-editor-customizer', get_template_directory_uri() . '/js/customizer-panel.js', array( 'jquery' ), rand(), true );
}
add_action( 'customize_controls_enqueue_scripts', 'ftt_editor_customizer_script' );

function ftt_posts_filter( $query ) {
	if ( is_admin() || ! $query->is_main_query() || is_single() ) {
		return $query;
	}

	$query->set( 'post_status', 'publish' );
	$query->set( 'posts_per_page', get_theme_mod( 'recently_added_videos_number', 36 ) );

	$filter = isset( $_GET['filter'] ) ? $_GET['filter'] : '';
	switch ( $filter ) {
		case 'latest':
			$query->set( 'orderby', 'date' );
			$query->set( 'order', 'DESC' );
			break;
		case 'most-viewed':
			$query->set( 'meta_key', 'post_views_count' );
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'order', 'DESC' );
			break;
		case 'longest':
			$query->set( 'meta_key', 'duration' );
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'order', 'DESC' );
			break;
		case 'popular':
			$query->set( 'orderby', 'meta_value_num' );
			$query->set(
				'meta_query',
				array(
					'relation' => 'OR',
					array(
						'key'     => 'rate',
						'compare' => 'NOT EXISTS',
					),
					array(
						'key'     => 'rate',
						'compare' => 'EXISTS',
					),
				)
			);
			$query->set( 'order', 'DESC' );
			break;
		case 'random':
			$query->set( 'orderby', 'rand' );
			$query->set( 'order', 'DESC' );
			break;
		default;
			break;
	}
	return $query;
}
add_action( 'pre_get_posts', 'ftt_posts_filter', 1 );

/**
 * Check if the main_query is a list of videos with an ad inside of it.
 *
 * @return bool True if the main_query is a list of videos with an ad inside of it.
 */
function ftt_is_mainquery_a_list_with_ads() {
	if (
		// is home with homepage block enabled with some ads in it?
		( is_home() && '' !== get_theme_mod( 'ads_home_inside_list' ) ) ||
		// is home with filter or paged and with homepage block enabled with some ads in it?
		/* ( is_home() && is_active_sidebar( 'homepage' ) && ( isset( $_GET['filter'] ) || is_paged() ) && '' !== get_theme_mod( 'ads_home_inside_list' ) ) || */
		// is category page with category block enabled with some ads in it?
		( is_category() && '' !== get_theme_mod( 'ads_category_page_inside_list' ) ) ||
		// is tag page with tag block enabled with some ads in it?
		( is_tag() && '' !== get_theme_mod( 'ads_tag_page_inside_list' ) ) ||
		// is actors page with actors block enabled with some ads in it?
		( is_tax( 'actors' ) && '' !== get_theme_mod( 'ads_actor_page_inside_list' ) ) ||
		// is search page with search block enabled with some ads in it?
		( is_search() && '' !== get_theme_mod( 'ads_search_result_page_inside_list' ) )
		// is home with some ads
	) {
		return true;
	}
	return false;
}

if ( ! function_exists( 'ftt_get_video_preview' ) ) {
	function ftt_get_video_preview( $post_id = null ) {
		if ( null === $post_id ) {
			global $post;
			$post_id = $post->ID;
		}
		$post_id        = intval( $post_id );
		$trailer_url    = get_post_meta( $post_id, 'trailer_url', true );
		$trailer_format = explode( '.', $trailer_url );
		$trailer_format = $trailer_format[ count( $trailer_format ) - 1 ];
		$trailer_video  = '<video width="100%" height="100%" autoplay loop muted preload="none"><source src="' . $trailer_url . '" type="video/' . $trailer_format . '">Your browser does not support the video tag.</video>';
		if ( $trailer_url ) {
			return $trailer_video;
		} else {
			return;
		}
	}
}

/**
 * Replace accented characters with non accented
 */
function ftt_removeAccents( $str ) {
	$a = array( 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή' );
	$b = array( 'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η' );
	return str_replace( $a, $b, $str );
}

/**
 * Selected filters
 */
function ftt_selected_filter( $filter ) {
	$current_filter = '';
	if ( isset( $_GET['filter'] ) ) {
		$current_filter = $_GET['filter'];
	}
	if ( $current_filter == $filter ) {
		return 'active';
	}
	return false;
}

function ftt_get_filter_title() {
	$title  = '';
	$filter = '';
	if ( isset( $_GET['filter'] ) ) {
		$filter = $_GET['filter'];
	} else {
		$filter = xbox_get_field_value( 'ftt-options', 'show-videos-homepage' );
	}
	switch ( $filter ) {
		case 'latest':
			$title = esc_html__( 'คลิปใหม่ล่าสุด', 'wpst' );
			break;
		case 'most-viewed':
			$title = esc_html__( 'คลิปที่คนดูมากที่สุด', 'wpst' );
			break;
		case 'longest':
			$title = esc_html__( 'คลิปเก่า', 'wpst' );
			break;
		case 'popular':
			$title = esc_html__( 'คลิปนิยมที่สุด', 'wpst' );
			break;
		case 'random':
			$title = esc_html__( 'สุ่มคลิป', 'wpst' );
			break;
		default:
			$title = esc_html__( 'คลิปเพิ่มใหม่ล่าสุด', 'wpst' );
			break;
	}
	return $title;
}

function ftt_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Homepage', 'wpst' ),
			'id'            => 'homepage',
			'description'   => esc_html__( 'Display widgets on your homepage.', 'wpst' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Video Sidebar', 'wpst' ),
			'id'            => 'video_sidebar',
			'description'   => esc_html__( 'Display widgets in the single video page sidebar.', 'wpst' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

add_filter( 'mce_css', 'ftt_remove_mce_css' );
function ftt_remove_mce_css( $stylesheets ) {
	return '';
}

function ftt_get_nopaging_url() {
	global $wp;

	$current_url  = home_url( $wp->request );
	$position     = strpos( $current_url, '/page' );
	$nopaging_url = ( $position ) ? substr( $current_url, 0, $position ) : $current_url;

	return trailingslashit( $nopaging_url );
}

function ftt_duration_custom_field( $updated, $field ) {
	$duration_hh = isset( $_POST['duration_hh'] ) ? $_POST['duration_hh'] : 0;
	$duration_mm = isset( $_POST['duration_mm'] ) ? $_POST['duration_mm'] : 0;
	$duration_ss = isset( $_POST['duration_ss'] ) ? $_POST['duration_ss'] : 0;
	$field->save( $duration_hh * 3600 + $duration_mm * 60 + $duration_ss );
}
add_action( 'xbox_after_save_field_duration', 'ftt_duration_custom_field', 10, 2 );

function ftt_render_shortcodes( $content ) {
	$regex = '/\[(.+)\]/m';
	preg_match_all( $regex, $content, $matches, PREG_SET_ORDER, 0 );

	// Print the entire match result
	if ( is_array( $matches ) ) {
		foreach ( $matches as $shortcode ) {
			$shortcode_with_brackets    = $shortcode[0];
			$shortcode_without_brackets = $shortcode[1];
			$should_be_shortcode        = explode( ' ', $shortcode_without_brackets );
			$should_be_shortcode        = current( $should_be_shortcode );
			if ( shortcode_exists( $should_be_shortcode ) ) {
				$shortcode = do_shortcode( $shortcode_with_brackets );
				return $shortcode;
			}
		}
	}
	return $content;
}

function ftt_change_post_label() {
	global $menu;
	global $submenu;
	$menu[5][0]                 = 'Videos';
	$submenu['edit.php'][5][0]  = 'Videos';
	$submenu['edit.php'][10][0] = 'Add Video';
	$submenu['edit.php'][15][0] = 'Video Categories';
	$submenu['edit.php'][16][0] = 'Video Tags';
}
function ftt_change_post_object() {
	global $wp_post_types;
	$labels                     = &$wp_post_types['post']->labels;
	$labels->name               = 'Videos';
	$labels->singular_name      = 'Videos';
	$labels->add_new            = 'Add Video';
	$labels->add_new_item       = 'Add Video';
	$labels->edit_item          = 'Edit Video';
	$labels->new_item           = 'Videos';
	$labels->view_item          = 'View Videos';
	$labels->search_items       = 'Search Videos';
	$labels->not_found          = 'No Videos found';
	$labels->not_found_in_trash = 'No Videos found in Trash';
	$labels->all_items          = 'All Videos';
	$labels->menu_name          = 'Videos';
	$labels->name_admin_bar     = 'Videos';
}

add_action( 'admin_menu', 'ftt_change_post_label' );
add_action( 'init', 'ftt_change_post_object' );

function ftt_change_cat_object() {
	global $wp_taxonomies;
	$labels                     = &$wp_taxonomies['category']->labels;
	$labels->name               = 'Video Category';
	$labels->singular_name      = 'Video Category';
	$labels->add_new            = 'Add Video Category';
	$labels->add_new_item       = 'Add Video Category';
	$labels->edit_item          = 'Edit Video Category';
	$labels->new_item           = 'Video Category';
	$labels->view_item          = 'View Video Category';
	$labels->search_items       = 'Search Video Categories';
	$labels->not_found          = 'No Video Categories found';
	$labels->not_found_in_trash = 'No Video Categories found in Trash';
	$labels->all_items          = 'All Video Categories';
	$labels->menu_name          = 'Video Category';
	$labels->name_admin_bar     = 'Video Category';
}
add_action( 'init', 'ftt_change_cat_object' );

function ftt_change_tag_object() {
	global $wp_taxonomies;
	$labels                     = &$wp_taxonomies['post_tag']->labels;
	$labels->name               = 'Video Tag';
	$labels->singular_name      = 'Video Tag';
	$labels->add_new            = 'Add Video Tag';
	$labels->add_new_item       = 'Add Video Tag';
	$labels->edit_item          = 'Edit Video Tag';
	$labels->new_item           = 'Video Tag';
	$labels->view_item          = 'View Video Tag';
	$labels->search_items       = 'Search Video Tags';
	$labels->not_found          = 'No Video Tags found';
	$labels->not_found_in_trash = 'No Video Tags found in Trash';
	$labels->all_items          = 'All Video Tags';
	$labels->menu_name          = 'Video Tag';
	$labels->name_admin_bar     = 'Video Tag';
}
add_action( 'init', 'ftt_change_tag_object' );

function replace_admin_menu_icons_css() {
	?>
	<style>
		#menu-posts .dashicons-admin-post::before, #menu-posts .dashicons-format-standard::before {
			content: "\f236";
		}
	</style>
	<?php
}

add_action( 'admin_head', 'replace_admin_menu_icons_css' );

function ftt_rss_post_thumbnail( $content ) {
	global $post;
	if ( has_post_thumbnail( $post->ID ) ) {
		$content = '<p>' . get_the_post_thumbnail( $post->ID ) . '</p>' . $content;
	}
	return $content;
}
add_filter( 'the_excerpt_rss', 'ftt_rss_post_thumbnail' );
add_filter( 'the_content_feed', 'ftt_rss_post_thumbnail' );

/* Remove admin bar for logged in users */
function ftt_remove_admin_bar() {
	if ( ! current_user_can( 'administrator' ) && ! is_admin() && xbox_get_field_value( 'ftt-options', 'display-admin-bar' ) == 'off' ) {
		show_admin_bar( false );
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
	}
}
add_action( 'get_header', 'ftt_remove_admin_bar' );

/**
 * Modify the "must_log_in" string of the comment form.
 */
add_filter(
	'comment_form_defaults',
	function( $fields ) {
		$fields['must_log_in'] = sprintf(
			__(
				'<p class="must-log-in">
                 You must be <a href="#ftt-login">logged in</a> to post a comment.</p>'
			),
			wp_registration_url(),
			wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
		);
		return $fields;
	}
);

function ftt_get_sources_from_hls( $hls_url ) {
	$pared_hls_url = parse_url( $hls_url );
	$referer       = $pared_hls_url['scheme'] . '://' . $pared_hls_url['host'];

	$base_url_regex = '/^(.+)\//';
	preg_match( $base_url_regex, $hls_url, $m3u8_matches, PREG_OFFSET_CAPTURE, 0 );
	$base_url = $m3u8_matches[0][0];

	$hls_body = ftt_curl( $hls_url, $referer );
	// $hls_body_regex = '/(hls-.+\s)/mU';
	$hls_body_regex = '/RESOLUTION=\d+x(.+)\W.*\s(.+\.m3u8.*)(?:$|\s)/mU';

	preg_match_all( $hls_body_regex, $hls_body, $hls_matches, PREG_SET_ORDER, 0 );

	$resolutions = array();

	foreach ( $hls_matches as $hls_match ) {
		$res                 = $hls_match[1];
		$hls_file            = $base_url . $hls_match[2];
		$resolutions[ $res ] = $hls_file;
	}
	krsort( $resolutions );
	foreach ( $resolutions as $res => $hls_file ) {
		$label    = (int) $res > 3000 ? '4K' : (string) $res . 'p';
		$output[] = "<source src=\"$hls_file\" label=\"$label\" type=\"application/x-mpegURL\"/>";
	}
	return implode( '', $output );
}

function ftt_curl( $url, $referer, $type = null ) {
	ini_set( 'memory_limit', '256M' );
	$agent = ( $type != null ) ? 'Mozilla/5.0 (Linux; U; Android 4.0; en-us; GT-I9300 Build/IMM76D)' : 'Mozilla/5.0(Windows;U;WindowsNT5.0;en-US;rv:1.4)Gecko/20030624Netscape/7.1(ax)';
	$ch    = curl_init( $url );
	curl_setopt( $ch, CURLOPT_USERAGENT, $agent );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
	curl_setopt( $ch, CURLOPT_REFERER, $referer );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
	$page = curl_exec( $ch );
	curl_close( $ch );
	return $page;
}