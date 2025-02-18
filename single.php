<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header();

add_filter(
	'theme_mod_seo_related_videos_title',
	function( $value ) {
		return str_replace( '%%video_title%%', get_the_title(), $value );
	}
); ?>

<div class="wrapper" id="single-wrapper">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			get_template_part( 'loop-templates/content', 'single-video' );
		endwhile;
	endif;
	?>
</div>
<?php
	get_footer();
