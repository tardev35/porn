
<?php
	add_filter(
		'theme_mod_seo_video_title',
		function( $value ) {
			$video_title = get_the_title();
			$value      = str_replace( '%%video_title%%', $video_title, $value );
			return $value;
		}
	);
	add_filter(
		'theme_mod_seo_video_tracking_button',
		function( $value ) {
			$video_title = get_the_title();
			$value      = str_replace( '%%video_title%%', $video_title, $value );
			return $value;
		}
	);
	$video_title        = get_the_title();
	$video_tracking_url = get_post_meta($post->ID, 'tracking_url', true);
	if ( has_post_thumbnail() ) {
		$video_thumb_url = get_the_post_thumbnail_url(get_the_id(), 'video-thumb');
	}else{
		$video_thumb_url = get_post_meta( get_the_ID(), 'thumb', true );
	}

	//Above related videos Ads
	$ads = array(
		'under_player'    => ftt_render_shortcodes( get_theme_mod( 'ads_single_video_page_under_player', '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-3.png"></a>' ) ),
		'beside_player_1' => ftt_render_shortcodes( get_theme_mod( 'ads_single_video_page_beside_player_1', '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>' ) ),
		'beside_player_2' => ftt_render_shortcodes( get_theme_mod( 'ads_single_video_page_beside_player_2', '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>' ) ),
		'page_bottom'     => ftt_render_shortcodes( get_theme_mod( 'ads_single_video_page_bottom', '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-4.png"></a>' ) ),
	);

// if(have_posts()) : while(have_posts()) : the_post();

$has_ftt_beside_player_ad_zone_desktop = $ads['beside_player_1'] || $ads['beside_player_2']; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
	<section class="single-video-player">
		<div class="container">
			<div class="row no-gutters">
				<div class="col-12 <?php if ( $has_ftt_beside_player_ad_zone_desktop ) : ?>col-md-9<?php else : ?>col-md-12<?php endif; ?>">
					<div class="video-wrapper">
						<?php get_template_part( 'loop-templates/content', 'video-player' ); ?>
						<?php if( get_post_meta( $post->ID, 'unique_ad_under_player', true ) != '' ) : ?>
							<div class="happy-under-player">
								<?php echo get_post_meta( $post->ID, 'unique_ad_under_player', true ); ?>
							</div>
						<?php elseif($ads['under_player']) : ?>
							<div class="happy-under-player">
								<?php echo $ads['under_player']; ?>
							</div>
						<?php endif; ?>
						<div class="video-title">
							<h1><?php echo get_theme_mod( 'seo_video_title', $video_title ); ?></h1>
						</div>
						<div class="video-actions-header">
							<div class="row no-gutters">
								<div class="col-12 col-md-3" id="rating">
									<span id="video-rate"><?php echo ftt_getPostLikeLink(get_the_ID()); ?></span>
									<?php $is_rated_yet = ftt_getPostLikeRate(get_the_ID()) === false ? " not-rated-yet" : ''; ?>
								</div>
								<div class="col-12 col-md-9 tabs" id="video-tabs">
									<button class="tab-link active about" data-tab-id="video-about"><i class="fa fa-info-circle"></i> <?php esc_html_e('About', 'wpst'); ?></button>
									<button class="tab-link share" data-tab-id="video-share"><i class="fa fa-share-alt"></i> <?php esc_html_e('Share', 'wpst'); ?></button>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<div class="video-actions-content">
							<div class="row no-gutters">
								<div class="col-12 col-md-3" id="rating-col">
									<div id="video-views"><span class="views-number"></span> <?php esc_html_e('views', 'wpst'); ?></div>
									<div class="rating-bar">
										<div class="rating-bar-meter"></div>
									</div>
									<div class="rating-result">
											<div class="percentage">0%</div>
										<div class="likes">
											<i class="fa fa-thumbs-up"></i> <span class="likes_count">0</span>
											<i class="fa fa-thumbs-down fa-flip-horizontal"></i> <span class="dislikes_count">0</span>
										</div>
									</div>
								</div>
								<div class="col-12 col-md-9">
									<div class="tab-content">
										<div class="video-content-row" id="video-about">
												<div class="video-description">
													<div class="desc">
														<?php the_content(); ?>
													</div>
												</div>
											<div class="video-content-row" id="video-author">
												<?php esc_html_e('From', 'wpst'); ?>: <?php the_author_posts_link(); ?>
											</div>
											<?php $actors = wp_get_post_terms($post->ID, "actors"); ?>
											<?php if( !empty($actors) ) : ?>
												<div class="video-content-row" id="video-actors">
													<?php esc_html_e('Actors', 'wpst'); ?>:
													<?php foreach($actors as $actor) {
														$actor_list[] = '<a href="' . get_term_link($actor->term_id) . '" title="' . $actor->name . '">' . $actor->name . '</a>';
													} echo implode( ', ', $actor_list ); ?>
												</div>
											<?php endif; ?>
											<?php $postcats = get_the_category(); ?>
											<?php if( !empty($postcats) ) : ?>
												<div class="video-content-row" id="video-cats">
													<?php esc_html_e('Category', 'wpst'); ?>:
													<?php foreach($postcats as $cat) {
														$cat_list[] = '<a href="' . get_category_link( $cat->term_id ) . '" title="' . $cat->name . '">' . $cat->name . '</a>';
													} echo implode( ', ', $cat_list ); ?>
												</div>
											<?php endif; ?>
											<?php $posttags = get_the_tags(); ?>
											<?php if( !empty($posttags) ) : ?>
												<div class="video-content-row" id="video-tags">
													<?php esc_html_e('Tags', 'wpst'); ?>:
													<?php foreach($posttags as $tag) {
														$tag_list[] = '<a href="' . get_tag_link( $tag->term_id ) . '" title="' . $tag->name . '">' . $tag->name . '</a>';
													} echo implode( ', ', $tag_list ); ?>
												</div>
											<?php endif; ?>
											<div class="video-content-row" id="video-date">
												<?php esc_html_e('Added on', 'wpst'); ?>: <?php the_time('F j, Y') ?>
											</div>
										</div>
										<?php get_template_part( 'template-parts/content', 'share-buttons' ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="video-wrapper">
					<?php
						$related = get_posts( array(
							'category__in' => wp_get_post_categories($post->ID),
							'numberposts' => '12',
							'post__not_in' => array($post->ID),
							'orderby' => 'rand',
							'order'    => 'ASC',
							)
						);
						if ( $related ) : ?>
						<div class="related-videos 5555">
						<h2>แจกคลิปเด็ดที่คุณต้องดู</h2>
							<div class="row no-gutters">
								
								<?php
									foreach( $related as $post ) {
										setup_postdata($post);
										get_template_part( 'loop-templates/loop', 'video' );
									}
								?>
							</div>
						</div>
						<?php wp_reset_postdata(); endif; ?>
					</div>
					<div class="video-wrapper">
						<div class="video-comments">
							<?php comments_template(); ?>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-3 video-sidebar">
					<?php if ( $has_ftt_beside_player_ad_zone_desktop ) : ?>
						<div class="happy-player-beside">
							<div class="zone-1"><?php echo $ads['beside_player_1']; ?></div>
							<div class="zone-2"><?php echo $ads['beside_player_2']; ?></div>
						</div>
					<?php endif; ?>

					<?php if ( function_exists('dynamic_sidebar') && is_active_sidebar('video_sidebar') ) {
						dynamic_sidebar('Video Sidebar');
					} ?>
			</div>
		</div>
	</section>
</article>

<?php if ( $ads['page_bottom'] ) : ?>
	<div class="happy-section"><?php echo $ads['page_bottom']; ?></div>
<?php endif; ?>

<?php // endwhile; endif; ?>
