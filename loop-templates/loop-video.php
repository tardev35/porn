<?php
$show_duration          = get_theme_mod( 'video_listing_general_show_duration', 'yes' );
$show_title             = get_theme_mod( 'video_listing_general_show_title', 'yes' );
$video_display_name     = get_the_title();
$video_loop_has_ad      = get_query_var( 'video_loop_has_ad', false );
$video_counter          = get_query_var( 'video_counter', 0 );
$video_order            = '';
$trailer_url            = get_post_meta( get_the_ID(), 'trailer_url', true );
$enable_video_preview   = get_theme_mod( 'enable_video_preview', 'yes' );
$enable_thumbs_rotation = get_theme_mod( 'enable_thumbs_rotation', 'yes' );

$video_thumb_url = '';
if ( has_post_thumbnail() ) {
	$video_thumb_url = get_the_post_thumbnail_url( get_the_id(), 'video-thumb' );
} elseif ( '' !== get_post_meta( get_the_ID(), 'thumb', true ) ) {
	$video_thumb_url = get_post_meta( get_the_ID(), 'thumb', true );
}
?>

<?php
if ( $video_loop_has_ad ) :
	$video_order = implode(
		' ',
		array(
			''   => 'order-' . ( $video_counter <= 2 ? '0' : '2' ),
			'sm' => 'order-sm-' . ( $video_counter <= 2 ? '0' : '2' ),
			'md' => 'order-md-' . ( $video_counter <= 1 ? '0' : '2' ),
			'lg' => 'order-lg-' . ( $video_counter <= 2 ? '0' : '2' ),
			'xl' => 'order-xl-' . ( $video_counter <= 4 ? '0' : '2' ),
		)
	);
endif;
?>

<div class="<?php echo esc_html( $video_order ); ?> col-12 col-md-3 col-lg-3 test">
	<div
		class="video-block <?php echo ( '' !== $trailer_url ? 'video-with-trailer' : 'thumbs-rotation' ); ?>"
		data-post-id="<?php echo intval( get_the_ID() ); ?>"
		<?php if ( ! $trailer_url ) : ?>
			data-thumbs="<?php echo esc_attr( ftt_get_multithumbs( get_the_ID() ) ); ?>"
		<?php endif; ?>
	>
		<?php echo apply_filters( 'wps_paywall_premium_badge', '', $post->ID ); ?>
		<a class="thumb" href="<?php the_permalink(); ?>">
			<div class="video-debounce-bar"></div>
			<?php if ( $video_thumb_url ) : ?>
				<img class="video-img img-fluid" data-src="<?php echo esc_url( $video_thumb_url ); ?>">
			<?php else : ?>
				<div class="no-thumb"></div>
			<?php endif; ?>
			<div class="video-preview"></div>
			<?php if ( ftt_get_video_duration() != '' ) : ?>
				<span class="duration"><?php echo ftt_get_video_duration(); ?></span>
			<?php endif; ?>
		</a>
		<a class="infos" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<span class="title"><?php the_title(); ?></span>
		</a>
		<div class="video-datas">
			<span class="views-number"><?php echo ftt_getPostViews( get_the_ID() ); ?> <i class="fa fa-eye"></i></span>
			<?php if ( ftt_getPostLikeRate( get_the_ID() ) != false ) : ?>
				<span class="rating"><i class="fa fa-thumbs-up"></i> <?php echo ftt_getPostLikeRate( get_the_ID() ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
// Add line breakers for ad zone.
// No breaker needed for <= small devices.
if ( $video_loop_has_ad ) :
	// md case.
	if ( 2 === $video_counter ) {
		echo '<div class="d-none d-md-block d-lg-none order-2 w-100"></div>';
	}
	// lg case.
	if ( 4 === $video_counter ) {
		echo '<div class="d-none d-lg-block d-xl-none order-2 w-100"></div>';
	}
	// xl case.
	if ( 8 === $video_counter ) {
		echo '<div class="d-none d-xl-block order-2 w-100"></div>';
	}
endif;