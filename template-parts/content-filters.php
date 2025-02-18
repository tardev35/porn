<?php if(!is_single() && !is_page()) : ?>
    <div id="filters">        
        <div class="filters-select"><?php if( !wp_is_mobile() ) : ?><?php echo ftt_get_filter_title(); ?><?php else : ?><i class="fa fa-filter"></i><?php endif; ?>
            <div class="filters-options">
                <?php $paged = get_query_var( 'paged', 1 ); ?>
                <?php if( $paged === 0 ) : ?>	
                    <span><a class="<?php echo ftt_selected_filter('latest'); ?>" href="<?php echo add_query_arg('filter', 'latest'); ?>"><?php esc_html_e('คลิปเพิ่มใหม่ล่าสุด', 'wpst'); ?></a></span>
                    <span><a class="<?php echo ftt_selected_filter('most-viewed'); ?>" href="<?php echo add_query_arg('filter', 'most-viewed'); ?>"><?php esc_html_e('คลิปผู้ชมมากที่สุด', 'wpst'); ?></a></span>
                    <span><a class="<?php echo ftt_selected_filter('longest'); ?>" href="<?php echo add_query_arg('filter', 'longest'); ?>"><?php esc_html_e('คลิปเก่านิยม', 'wpst'); ?></a></span>			
                    <span><a class="<?php echo ftt_selected_filter('popular'); ?>" href="<?php echo add_query_arg('filter', 'popular'); ?>"><?php esc_html_e('คลิปนิยมที่สุด', 'wpst'); ?></a></span>			
                    <span><a class="<?php echo ftt_selected_filter('random'); ?>" href="<?php echo add_query_arg('filter', 'random'); ?>"><?php esc_html_e('สุ่มคลิป', 'wpst'); ?></a></span>	
                <?php else : ?>
                    <span><a class="<?php echo ftt_selected_filter('latest'); ?>" href="<?php echo ftt_get_nopaging_url(); ?>?filter=latest"><?php esc_html_e('คลิปเพิ่มใหม่ล่าสุด', 'wpst'); ?></a></span>
                    <span><a class="<?php echo ftt_selected_filter('most-viewed'); ?>" href="<?php echo ftt_get_nopaging_url(); ?>?filter=most-viewed"><?php esc_html_e('คลิปผู้ชมมากที่สุด', 'wpst'); ?></a></span>				
                    <span><a class="<?php echo ftt_selected_filter('longest'); ?>" href="<?php echo ftt_get_nopaging_url(); ?>?filter=longest"><?php esc_html_e('คลิปเก่านิยม', 'wpst'); ?></a></span>				
                    <span><a class="<?php echo ftt_selected_filter('popular'); ?>" href="<?php echo ftt_get_nopaging_url(); ?>?filter=popular"><?php esc_html_e('คลิปนิยมที่สุด', 'wpst'); ?></a></span>			
                    <span><a class="<?php echo ftt_selected_filter('random'); ?>" href="<?php echo ftt_get_nopaging_url(); ?>?filter=random"><?php esc_html_e('สุ่มคลิป', 'wpst'); ?></a></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>