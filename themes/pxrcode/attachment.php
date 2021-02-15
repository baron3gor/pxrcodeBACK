<?php get_header(); ?>

<div class="pxr-page" role="main">

   <?php get_template_part('partials/content-page-header'); ?>

   <div class="pxr-page-attachment-wrapper pxr-wrapper pxr-page-inner">
      <div class="pxr-page-attachment">
         <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
               <div>
                  <div>
                     <?php if (wp_attachment_is_image($post->ID)) : $att_image = wp_get_attachment_image_src($post->ID, "full"); ?>
                        <p><a href="<?php echo wp_get_attachment_url($post->ID); ?>" title="<?php the_title(); ?>" rel="attachment"><img src="<?php echo esc_url($att_image[0]); ?>" width="<?php echo esc_attr($att_image[1]); ?>" height="<?php echo esc_attr($att_image[2]); ?>" alt="<?php $post->post_excerpt; ?>" /></a>
                        </p>
                     <?php else : ?>
                        <a href="<?php echo wp_get_attachment_url($post->ID) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>
                     <?php endif; ?>
                  </div>
                  <h3 class="pxr-attachment-title"><?php esc_html(the_title(), 'pxrcode'); ?></h3>
                  <div class="pxr-attachment-desc">
                     <div><?php if (!empty($post->post_excerpt)) the_excerpt() ?></div>
                     <?php the_content(esc_html__('Continue reading <span class="meta-nav">&amp;raquo;</span>', 'pxrcode')); ?>
                     <?php wp_link_pages('before=<div class="page-link">' . esc_html__('Pages:', 'pxrcode') . '&amp;after=</div>') ?>
                  </div>
                  <div class="pxr-breadcrumb">
                     <div class="pxr-btn-wrapper">
                        <a class="pxr-button-default" href="<?php echo esc_js('javascript:history.go(-1)'); ?>"><?php esc_html_e('Go Back', 'pxrcode'); ?></a>
                     </div>
                  </div>
               </div>
            <?php endwhile;
         else : ?>
            <?php get_template_part('partials/notfound') ?>
         <?php endif; ?>
      </div>
   </div>

</div>

<?php get_footer(); ?>