<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<?php require get_template_directory() . '/inc/init.php'; ?>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( get_theme_mod( 'favicon_file' ) != '' ) : ?>
		<link rel="icon" href="<?php echo get_theme_mod( 'favicon_file' ); ?>">
	<?php endif; ?>
	<!-- Meta social networks -->
	<?php
	if ( is_single() ) {
		require get_template_directory() . '/inc/meta-social.php';
	}
	?>
	<!-- Google Analytics -->
	<?php
	if ( get_theme_mod( 'google_analytics_code' ) != '' ) {
		echo get_theme_mod( 'google_analytics_code' ); }
	?>
	<!-- Meta Verification -->
	<?php
	if ( get_theme_mod( 'meta_verification_code' ) != '' ) {
		echo get_theme_mod( 'meta_verification_code' ); }
	?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">
		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'wpst' ); ?></a>
		<div class="logo-search d-flex">
			<div class="container d-flex align-items-center justify-content-between">
				<!-- Menu mobile -->
				<button class="navbar-toggler hamburger hamburger--slider" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'wpst' ); ?>">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</button>
				<!-- Your site title as branding in the menu -->
				<?php if ( ! get_theme_mod( 'logo_file', '' ) ) { ?>
					<?php if ( is_front_page() && is_home() ) : ?>
						<?php /* <h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1> */ ?>
						<h1 class="navbar-brand mb-0">
							<a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url">
								<?php if ( get_theme_mod( 'logo_word_1', 'Your' ) != '' || get_theme_mod( 'logo_word_2', 'logo' ) != '' ) : ?>
									<span class="logo-word-1"><?php echo get_theme_mod( 'logo_word_1', 'Your' ); ?></span>
									<span class="logo-word-2"><?php echo get_theme_mod( 'logo_word_2', 'logo' ); ?></span>
								<?php else : ?>
									<?php bloginfo( 'name' ); ?>
								<?php endif; ?>
							</a>
						</h1>
					<?php else : ?>
						<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url">
							<?php if ( get_theme_mod( 'logo_word_1', 'Your' ) != '' || get_theme_mod( 'logo_word_2', 'logo' ) != '' ) : ?>
								<span class="logo-word-1"><?php echo get_theme_mod( 'logo_word_1', 'Your' ); ?></span>
								<span class="logo-word-2"><?php echo get_theme_mod( 'logo_word_2', 'logo' ); ?></span>
							<?php else : ?>
								<?php bloginfo( 'name' ); ?>
							<?php endif; ?>
						</a>
					<?php endif; ?>
				<?php } else { ?>
					<?php // the_custom_logo(); ?>
					<a class="logo-img" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><img src="<?php echo get_theme_mod( 'logo_file', '' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
				<?php } ?><!-- end custom logo -->

				<?php get_template_part( 'template-parts/content', 'header-search' ); ?>
				<?php if ( '1' === get_option( 'users_can_register' ) ) : ?>
					<div class="membership">
						<?php if ( is_user_logged_in() ) : ?>
							<?php
							// Retrieve first page with template "Submit a Video".
							$submit_a_video_pages = get_pages(
								array(
									'meta_key'   => '_wp_page_template',
									'meta_value' => 'template-video-submit.php',
									'number'     => 1,
								)
							);
							$submit_a_video_page  = is_array( $submit_a_video_pages ) && $submit_a_video_pages[0] instanceof WP_Post ? $submit_a_video_pages[0] : null;
							$my_profile_pages     = get_pages(
								array(
									'meta_key'   => '_wp_page_template',
									'meta_value' => 'template-my-profile.php',
									'number'     => 1,
								)
							);
							$my_profile_page      = is_array( $my_profile_pages ) && $my_profile_pages[0] instanceof WP_Post ? $my_profile_pages[0] : null;
							?>
							<div class="welcome menu-item-has-children"><?php echo get_avatar( get_current_user_id() ); ?> <i class="fa fa-caret-down"></i>
								<ul class="nav-menu sub-menu">
									<li class="welcome"><?php esc_html_e( 'Welcome', 'wpst' ); ?> <?php echo wp_kses_post( wp_get_current_user()->display_name ); ?></li>
									<?php if ( $submit_a_video_page instanceof WP_Post ) : ?>
										<li><a href="<?php echo esc_url( get_permalink( $submit_a_video_page->ID ) ); ?>"><i class="fa fa-upload"></i> <span class="topbar-item-text"><?php esc_html_e( 'Submit a Video', 'wpst' ); ?></span></a></li>
									<?php endif; ?>
									<li id="my-channel"><a href="<?php echo esc_url( get_author_posts_url( get_current_user_id() ) ); ?>"><i class="fa fa-video-camera"></i> <span class="topbar-item-text"><?php esc_html_e( 'My Channel', 'wpst' ); ?></span></a></li>
									<?php if ( $my_profile_page instanceof WP_Post ) : ?>
										<li><a href="<?php echo esc_url( get_permalink( $my_profile_page->ID ) ); ?>"><i class="fa fa-user"></i> <span class="topbar-item-text"><?php esc_html_e( 'My Profile', 'wpst' ); ?></span></a></li>
									<?php endif; ?>
									<li><a href="<?php echo esc_url( wp_logout_url( is_home() ? home_url() : get_permalink() ) ); ?>"><i class="fa fa-power-off"></i> <span class="topbar-item-text"><?php esc_html_e( 'Logout', 'wpst' ); ?></span></a></li>
								</ul>
							</div>
						<?php else : ?>
							<span class="login"><a href="#wpst-login"><?php esc_html_e( 'Login', 'wpst' ); ?></a></span>
							<span class="login"><a class="button" href="#wpst-register"><?php esc_html_e( 'Sign Up', 'wpst' ); ?></a></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<nav class="navbar navbar-expand-md navbar-dark">
			<div class="container">
				<!-- The WordPress Menu goes here -->
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'ftt-primary-menu',
						'container_class' => 'collapse navbar-collapse',
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'navbar-nav ml-auto',
						'fallback_cb'     => '',
						'depth'           => 2,
						'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
					)
				);
				?>
			</div><!-- .container -->
		</nav><!-- .site-navigation -->
	</div><!-- #wrapper-navbar end -->
