<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header(); ?>
<div class="wrapper" id="page-wrapper">
	<div class="container" id="content" tabindex="-1">
		<div class="row">
			<div class="col-12">
				<main class="site-main" id="main">
					<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : ?>
							<?php the_post(); ?>
							<?php get_template_part( 'loop-templates/content', 'page' ); ?>
							<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
							?>
						<?php endwhile; // end of the loop. ?>
					<?php endif; ?>
				</main><!-- #main -->
			</div>
		</div><!-- .row -->
	</div><!-- #content -->
</div><!-- #page-wrapper -->
<?php
	get_footer();
