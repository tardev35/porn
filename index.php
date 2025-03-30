<?php
defined('ABSPATH') || exit;
get_header();

$ads = array(
	'inside_list' => ftt_render_shortcodes(get_theme_mod('ads_home_inside_list', '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-2.png"></a>')),
	'page_bottom' => ftt_render_shortcodes(get_theme_mod('ads_home_page_bottom', '<a href="#!"><img src="' . get_template_directory_uri() . '/img/happy-4.png"></a>')),
);

add_filter(
	'theme_mod_seo_home_description',
	function ($value) {
		return str_replace("\n", '<br>', $value);
	}
);
?>
<div class="container">		
					<?php if (is_front_page()) : ?>
					 <?php 
					$homepage_h1 = get_field('homepage_h1', 'options');
					 if (!empty($homepage_h1)) :
				 echo '<h1 style="margin-bottom:5px;margin-top:10px;font-size:32px;text-align:center">' . esc_html($homepage_h1) . '</h1>';
				  else :
				   echo '<h1>Default Homepage Title</h1>'; // ใช้ค่าเริ่มต้นหากไม่มีข้อมูล
				   endif;
					  ?>
					  <?php endif; ?>

</div>

<div class="slide">
	<div class="owl-carousel owl-theme">
		<?php
		$argss = array(
			'post_type' => 'post',
			'tax_query' => array(
				array(
					'taxonomy' => 'slide',
					'field' => 'slug',
					'terms' => 'slide'
				)
			)
		);
		$room_querys = new WP_Query($argss);
		if ($room_querys->have_posts()) {
			while ($room_querys->have_posts()) {
				$room_querys->the_post();
				get_template_part('loop-templates/loop', 'slide')
					?>
				<?php
			}
			wp_reset_postdata();
		}
		?>
	</div>
</div>
<div id="content">

	<div class="container">

		<?php if (have_posts()):
			if (function_exists('dynamic_sidebar') && is_active_sidebar('homepage') && !isset($_GET['filter']) && !is_paged()) {
				dynamic_sidebar('Homepage');
			} ?>
			<div class="page-header">
				<h2 class="widget-title mt-4"><?php echo ftt_get_filter_title(); ?> 🔥🔥</h2>
				<?php get_template_part('template-parts/content', 'filters'); ?>
			</div>
			<div class="row" style="justify-content: space-around;">
				<div class="video-loop col-xl-9 col-lg-9 col-md-9 col-12 left-side">
					<div class="row no-gutters">
						<div class="order-1 order-sm-1 order-md-1 order-lg-1 order-xl-1 col-12 col-md-6 col-lg-6 col-xl-4">
							<?php if ('' !== $ads['inside_list'] && wp_count_posts() > '1'): ?>
								<div class="video-block-happy">
									<div class="video-block-happy-absolute d-flex align-items-center justify-content-center">
										<?php echo $ads['inside_list']; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<?php
						if (have_posts()):
							$video_counter = 0;
							set_query_var('video_loop_has_ad', ('' !== $ads['inside_list']));
							while (have_posts()):
								$video_counter++;
								set_query_var('video_counter', $video_counter);
								the_post();
								get_template_part('loop-templates/loop', 'video');
							endwhile;
						endif;
						?>
					</div>
					<?php ftt_pagination(); ?>
				</div>
				<div class="video-loop col-xl-3 col-lg-3 col-md-3 col-12 right-side">
					<h2>Onlyfans ห้ามพลาด 🔥🔥</h2>
					<div class="row no-gutters">
						<?php
						$args = array(
							'post_type' => 'post',
							'tax_query' => array(
								array(
									'taxonomy' => 'category',
									'field' => 'slug',
									'terms' => '%e0%b8%84%e0%b8%a5%e0%b8%b4%e0%b8%9b%e0%b8%ab%e0%b8%a5%e0%b8%b8%e0%b8%94-onlyfans'
								)
							),
							'posts_per_page' => 10
						);
						$room_query = new WP_Query($args);
						if ($room_query->have_posts()) {
							while ($room_query->have_posts()) {
								$room_query->the_post();
								get_template_part('loop-templates/loop', 'right')
									?>
								<?php
							}
							wp_reset_postdata();
						}
						?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php if ($ads['page_bottom']): ?>
		<div class="happy-section"><?php echo $ads['page_bottom']; ?></div>

	<?php endif; ?>

	<div class="container mb-4">
		<div class="row">
			<div class="video-loop col-xl-12 col-lg-12 col-md-12 col-12">
			<div class="header-video">
				<h2>คลิปหลุด VK</h2>
				<a class="more-videos label" href="/category/คลิปหลุด-vk"	target="_self" rel="follow noopener noreferrer"><i style="font-size: 18px;" class="fa fa-plus"></i></a>
				</div>
				<div class="row no-gutters">
					<?php
					$argsvk = array(
						'post_type' => 'post',
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'field' => 'slug',
								'terms' => '%e0%b8%84%e0%b8%a5%e0%b8%b4%e0%b8%9b%e0%b8%ab%e0%b8%a5%e0%b8%b8%e0%b8%94-vk'
							)
						),
						'posts_per_page' => 6
					);
					$vk_query = new WP_Query($argsvk);
					if ($vk_query->have_posts()) {
						while ($vk_query->have_posts()) {
							$vk_query->the_post();
							get_template_part('loop-templates/loop', 'vk')
								?>
							<?php
						}
						wp_reset_postdata();
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="video-loop col-xl-12 col-lg-12 col-md-12 col-12">
				<div class="header-video">
				<h2>คลิปหลุด นึกศึกษา</h2>
				<a class="more-videos label" href="category/คลิปหลุดนักศึกษา"	target="_self" rel="follow noopener noreferrer"><i style="font-size: 18px;" class="fa fa-plus"></i></a>
				</div>
				
				<div class="row no-gutters">
					<?php
					$argsst = array(
						'post_type' => 'post',
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'field' => 'slug',
								'terms' => '%e0%b8%84%e0%b8%a5%e0%b8%b4%e0%b8%9b%e0%b8%ab%e0%b8%a5%e0%b8%b8%e0%b8%94%e0%b8%99%e0%b8%b1%e0%b8%81%e0%b8%a8%e0%b8%b6%e0%b8%81%e0%b8%a9%e0%b8%b2'
							)
						),
						'posts_per_page' => 6
					);
					$st_query = new WP_Query($argsst);
					if ($st_query->have_posts()) {
						while ($st_query->have_posts()) {
							$st_query->the_post();
							get_template_part('loop-templates/loop', 'vk')
								?>
							<?php
						}
						wp_reset_postdata();
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="hero">
		<div class="container" tabindex="-1">
			<div class="hero-text">
				<p style="font-size:16px;font-color:#fff;">คลิปหลุดหีไทย ล้วน ๆ ดูคลิปหลุดมาใหม่เด็ด ๆ คลิปหลุดทางบ้าน
					ไทย18+ หีไทยสด ๆ ส่งตรงจากเอ็มไลฟ์และโอนลี่แฟน VK แอบตั้งกล้องถ่ายกับแบบสุดเสียว คลิปหลุดล่าสุด
					มาใหม่ก็มีให้เลือกดูกันแบบไม่ซ้ำหน้า AV ทางบ้านจากจีนสวยเด็ดก็มีให้ดู อัพเดทใหม่ล่าสุด ไม่เซ็นเซอร์​
					หลุด มาใหม่ คลิปหลุดเด็ดๆ ทั่วทุกรูปแบบ ไม่ซ้ำ หีใหญ่ หีสวย หีน้องนักเรียนนักศึกษา เช่น หีน้องกวาง
					หีน้องกัส หีน้องคะแนน หีน้องคุกกี้ หีน้องจอย หีน้องตูน หีน้องปลาทอง หีน้องพลอย หีน้องมาย หีน้องอะตอม
					หีน้องฮาย หีน้องไข่เน่า หีใหญ่ ๆ เต็มไปหมด ต่างหีเนียนกริบ สาวสวยหมวยเอ็กซ์ ขาวหุ่นเด็ด น่าเอา
					เว็บดูหีไทยต้องที่ เสยหี.com เท่านั้น</p>
				<p><?php
				/**echo get_theme_mod( 'seo_home_description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.' ); **/
				?></p>
			</div>
		</div>
	</div>
	<h3 style="text-align:center; padding:10px; margin:0">หมวดหมู่คลิป</h3>
	<section class="hero get-cat bage">
		<?php if (taxonomy_exists('category')) { ?>
			<?php
			$terms = get_terms(array(
				'taxonomy' => 'category',
				'hide_empty' => false,
			));
			foreach ($terms as $term) {
				$term_name = $term->name;
				$termlink = get_term_link($term);
				echo "<a class='cat-link' href='$termlink'>$term_name</a>";
			}
			;
			?>
		<?php } else {
			echo "Can not read";
		} ?>
	</section>
	<h3 style="text-align:center; padding:10px; margin:0">ประเภทคลิป</h3>
	<section class="hero get-cat bage">
		<?php if (taxonomy_exists('post_tag')) { ?>
			<?php
			$actors = get_terms(array(
				'taxonomy' => 'post_tag',
				'hide_empty' => false,
			));
			foreach ($actors as $actor) {
				$actor_name = $actor->name;
				$actorlink = get_term_link($actor);
				echo "<a class='post-link' href='$actorlink'>$actor_name</a>";
			}
			;
			?>
		<?php } else {
			echo "Can not read";
		} ?>
	</section>
</div>
<?php
get_footer();