<?php
/**
 * @package Priimo
 */
?>
<?php global $priimo_options; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
        if(trim(get_the_post_thumbnail($post->ID)) != ''):
			$imgId = get_post_thumbnail_id($post->ID);
            $imgsrc = wp_get_attachment_image_src($imgId,'full',false);
            $img = $imgsrc[0];
    ?>
        <h1 class="entry-title title_header" style="background-image: url(<?php echo $img; ?>); background-repeat: no-repeat; background-position: left center;"><span class="title_header_text"><?php the_title(); ?></span></h1>
    <?php else: ?>
        <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php endif; ?>
    <?php if($priimo_options['show_page_meta']): ?>
    <div class="entry-meta">
        <?php priimo_posted_on(); ?>
        <?php if(comments_open() && ! post_password_required()) : ?>
        <?php comments_popup_link(__('Reply', 'priimo'), _x('1 Comment', 'comments number', 'priimo'), _x('% Comments', 'comments number', 'priimo'), 'entry-comments'); ?>
        <?php edit_post_link(__('Edit', 'priimo')); ?>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="entry-content">
        <?php the_content(__('Continue reading', 'priimo')); ?>
        <?php wp_link_pages(array('before' => '<div class="page-link clearfix"><span class="pages-title">'.__('Pages:','priimo').'</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
    </div>
</article>