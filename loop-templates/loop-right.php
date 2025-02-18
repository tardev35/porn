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

<div class="col-6 col-md-6 col-lg-6 test">
	<div class="video-block <?php echo ( '' !== $trailer_url ? 'video-with-trailer' : 'thumbs-rotation' ); ?>"
		data-post-id="<?php echo intval( get_the_ID() ); ?>"
		<?php if ( ! $trailer_url ) : ?>
			data-thumbs="<?php echo esc_attr( ftt_get_multithumbs( get_the_ID() ) ); ?>"
		<?php endif; ?>>
		<a class="thumb" href="<?php the_permalink(); ?>">
			<?php if ( $video_thumb_url ) : ?>
				<img class="video-img img-fluid" data-src="<?php echo esc_url( $video_thumb_url ); ?>">
			<?php else : ?>
				<div class="no-thumb"></div>
			<?php endif; ?>
			<div class="video-preview"></div>
			
		</a>
	</div>
</div>