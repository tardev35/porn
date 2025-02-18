<?php
function ftt_remove_video_from_content( $content ) {
	if ( ! is_single() ) {
		return $content;
	}

	if ( empty( $content ) ) {
		return $content;
	}

	$video_in_content = false;
	$video_code       = array();

	if ( preg_match( '/\[video.+\]/', $content, $video_code ) ) {
		$video_in_content = '/\[video.+\]/';
	} elseif ( preg_match( '/<iframe.+<\/iframe>/', $content, $video_code ) ) {
		$video_in_content = '/<iframe.+<\/iframe>/';
	} elseif ( preg_match( '/<video.+<\/video>/', $content, $video_code ) ) {
		$video_in_content = '/<video.+<\/video>/';
	} elseif ( preg_match( '/<object.+<\/object>/', $content, $video_code ) ) {
		$video_in_content = '/<object.+<\/object>/';
	} elseif ( preg_match( '/https:\/\/www.youtube.com\/watch\?v=.+?\b/', $content, $video_code ) ) {
		$video_in_content = '/https:\/\/www.youtube.com\/watch\?v=.+?\b/';
	}

	$embed_code      = get_post_meta( get_the_ID(), 'embed', true );
	$video_url       = get_post_meta( get_the_ID(), 'video_url', true );
	$video_shortcode = get_post_meta( get_the_ID(), 'shortcode', true );

	if ( false !== $video_in_content && ( '' === $embed_code && '' === $video_shortcode && '' === $video_url ) ) {
		return preg_replace( $video_in_content, '', $content );
	}
	return $content;
}
add_filter( 'the_content', 'ftt_remove_video_from_content' );
