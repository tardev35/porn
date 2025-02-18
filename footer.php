<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<div id="wrapper-footer">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<footer class="site-footer" id="colophon">
					<?php if ( has_nav_menu( 'ftt-footer-menu' ) ) : ?>
						<div class="footer-menu-container">
							<?php wp_nav_menu( array( 'theme_location' => 'ftt-footer-menu' ) ); ?>
						</div>
					<?php endif; ?>
					<div class="clear"></div>
					<div class="site-info">
						<?php echo get_theme_mod( 'copyright_content', date('Y') . ' - ' . get_bloginfo('name') . '. ' . esc_html__('All rights reserved. Powered by WP-Script.com') ); ?>
					</div><!-- .site-info -->
				</footer><!-- #colophon -->
			</div><!--col end -->
		</div><!-- row end -->
	</div><!-- container end -->
</div><!-- wrapper end -->
</div><!-- #page we need this extra closing tag here -->
<?php wp_footer(); ?>
<!-- Other scripts -->
<?php if( get_theme_mod( 'other_script_codes' ) != '' ) { echo get_theme_mod( 'other_script_codes' ); } ?>
</body>
</html>
