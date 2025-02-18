<?php
defined( 'ABSPATH' ) || exit;
get_header();

$search_number = $wp_query->found_posts;
$search_tag    = get_search_query();
$ads           = array(
	'inside_list' => ftt_render_shortcodes( get_theme_mod( 'ads_search_result_page_inside_list', '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>' ) ),
	'page_bottom' => ftt_render_shortcodes( get_theme_mod( 'ads_search_result_page_bottom', '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-4.png"></a>' ) ),
);
add_filter(
	'theme_mod_seo_search_title',
	function( $value ) use ( $search_number, $search_tag ) {
		$value = str_replace( '%%search_tag%%', $search_tag, $value );
		$value = str_replace( '%%search_number%%', $search_number, $value );
		return $value;
	}
);
add_filter(
	'theme_mod_seo_search_description',
	function( $value ) use ( $search_number, $search_tag ) {
		$value = str_replace( '%%search_tag%%', $search_tag, $value );
		$value = str_replace( '%%search_number%%', $search_number, $value );
		$value = str_replace( "\n", '<br>', $value );
		return $value;
	}
);
?>
<div id="content">
	<div class="container">
		<div class="page-header">
			<h1 class="widget-title mt-4"><?php echo esc_html( get_theme_mod( 'seo_search_title', $search_number . ' videos found with ' . $search_tag ) ); ?></h1>
			<?php if ( ! have_posts() ) : ?>
				<p><?php esc_html_e( 'It looks like nothing was found for this search. Maybe try one of the links below or a new search?', 'wpst' ); ?></p>
			<?php endif; ?>
			<?php if ( have_posts() ) : ?>
				<?php get_template_part( 'template-parts/content', 'filters' ); ?>
			<?php endif; ?>
		</div>
		<div class="video-loop mh800">
			<div class="row no-gutters">
				<div class="order-1 order-sm-1 order-md-1 order-lg-1 order-xl-1 col-12 col-md-6 col-lg-6 col-xl-4">
				<?php if ( '' !== $ads['inside_list'] ) : ?>
					<div class="video-block-happy">
						<div class="video-block-happy-absolute d-flex align-items-center justify-content-center">
							<?php echo $ads['inside_list']; ?>
						</div>
					</div>
				<?php endif; ?>
				</div>
						<?php
						$video_counter = 0;
						set_query_var( 'video_loop_has_ad', ( '' !== $ads['inside_list'] ) );
						if ( have_posts() ) :
							while ( have_posts() ) :
								$video_counter++;
								set_query_var( 'video_counter', $video_counter );
								the_post();
								get_template_part( 'loop-templates/loop', 'video' );
							endwhile;
						else :
							$rand_videos = get_posts(
								array(
									'numberposts' => '' !== $ads['inside_list'] ? '56' : '60',
									'orderby'     => 'rand',
								)
							);
							foreach ( $rand_videos as $post ) :
								$video_counter++;
								set_query_var( 'video_counter', $video_counter );
								get_template_part( 'loop-templates/loop', 'video' );
							endforeach;
						endif;
						?>
			</div>
			<?php ftt_pagination(); ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
	<?php if ( $ads['page_bottom'] ) : ?>
		<div class="happy-section"><?php echo $ads['page_bottom']; ?></div>
	<?php endif; ?>
	<div class="hero">
		<div class="container">
			<div class="hero-text">
				<p><?php echo get_theme_mod( 'seo_search_description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.' ); ?></p>
			</div>
		</div>
	</div>
</div>

<?php
	get_footer();
