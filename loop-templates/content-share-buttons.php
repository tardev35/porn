<?php
    //Thumbnail
    $thumb = get_post_meta($post->ID, 'thumb', true);
    if ( has_post_thumbnail() ) {
        $thumb_id = get_post_thumbnail_id();
        $thumb_url = wp_get_attachment_image_src($thumb_id, 'ftt_thumb_large', true);
        $poster = $thumb_url[0];
    }else{
        $poster = $thumb;
    }

    $post_data = ftt_get_post_data($post->ID);
    $url_image = has_post_thumbnail() ? wp_get_attachment_url( get_post_thumbnail_id($post->ID)) : $thumb;
    $current_url = get_permalink( $post->ID );
    $current_title = $post_data->post_title;
    $current_desc = '';
    if( !empty($post_data->post_content) ){
        $current_desc = esc_html($post_data->post_content);
    }else{
        $current_desc = 'test';
    }

?>
<?php /* <div id="video-share" <?php if(wp_is_mobile()) : ?>style="display: block;"<?php endif; ?>> */ ?>
    <!-- Facebook -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.12';
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $current_url; ?>&amp;src=sdkpreparse"><i id="facebook" class="fa fa-facebook"></i></a>

    <!-- Twitter -->
    <a target="_blank" href="https://twitter.com/home?status=<?php print $current_url;?>"><i id="twitter" class="fa fa-twitter"></i></a>

    <!-- Google Plus -->
    <a target="_blank" href="https://plus.google.com/share?url=<?php print $current_url;?>"><i id="googleplus" class="fa fa-google-plus"></i></a>

    <!-- Tumblr -->
    <a target="_blank" href="http://tumblr.com/widgets/share/tool?canonicalUrl=<?php print $current_url;?>"><i id="tumblr" class="fa fa-tumblr-square"></i></a>

    <!-- Reddit -->
    <a target="_blank" href="http://www.reddit.com/submit?url"><i id="reddit" class="fa fa-reddit-square"></i></a>

    <!-- Odnoklassniki -->
    <a target="_blank" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=<?php print $current_url;?>&title=<?php print $current_title;?>"><i id="odnoklassniki" class="fa fa-odnoklassniki"></i></a>

    <!-- VK -->
    <script type="text/javascript" src="https://vk.com/js/api/share.js?95" charset="windows-1251"></script>
    <a href="http://vk.com/share.php?url=<?php print $current_url;?>" target="_blank"><i id="vk" class="fa fa-vk"></i></a>

    <!-- Email -->
    <a target="_blank" href="mailto:?subject=&amp;body=<?php the_permalink(); ?>"><i id="email" class="fa fa-envelope"></i></a>
<?php /* </div> */ ?>
