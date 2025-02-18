<?php
	// Exit if accessed directly.
	defined( 'ABSPATH' ) || exit;
	get_header();

	$video_actor = get_queried_object();
	$ads         = array(
		'inside_list' => ftt_render_shortcodes( get_theme_mod( 'ads_actor_page_inside_list', '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>' ) ),
		'page_bottom' => ftt_render_shortcodes( get_theme_mod( 'ads_actor_page_bottom', '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-4.png"></a>' ) ),
	);
	add_filter(
		'theme_mod_seo_video_actor_title',
		function( $value ) use ( $video_actor ) {
			$value = str_replace( '%%actor%%', $video_actor->name, $value );
			return $value;
		}
	);
	add_filter(
		'theme_mod_seo_video_actor_description',
		function( $value ) use ( $video_actor ) {
			$value = str_replace( '%%actor%%', $video_actor->name, $value );
			$value = str_replace( "\n", '<br>', $value );
			return $value;
		}
	);
?>

<div id="content">
	<div class="container">
		<div class="page-header">
			<h1 class="widget-title mt-4 testtst actors"><?php echo ucfirst( get_theme_mod( 'seo_video_actor_title', $video_actor->name) ); ?></h1>
			<?php get_template_part( 'template-parts/content', 'filters' ); ?>
		</div>
		<div class="video-loop mh800 testtst">
			<div class="row no-gutters">
				<div class="col-12">
					<div class="row no-gutters">
						
						<?php
						if ( have_posts() ) :
							$video_counter = 0;
							set_query_var( 'video_loop_has_ad', ( '' !== $ads['inside_list'] ) );
							while ( have_posts() ) :
								$video_counter++;
								set_query_var( 'video_counter', $video_counter );
								the_post();
								get_template_part( 'loop-templates/loop', 'video' );
							endwhile;
						endif;
						?>
					</div>
				</div>
			</div>
			<?php ftt_pagination(); ?>
		</div>
	</div>
	<?php if ( $ads['page_bottom'] ) : ?>
		<div class="happy-section"><?php echo $ads['page_bottom']; ?></div>
	<?php endif; ?>
	<div class="hero">
		<div class="container">
			<div class="hero-text">
				<p><?php echo get_theme_mod( 'seo_video_cat_description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.' ); ?></p>
			</div>
		</div>
	</div>
</div>
<?php
	get_footer();
