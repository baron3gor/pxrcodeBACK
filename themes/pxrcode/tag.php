<?php get_header(); ?>

<div class="pxr-page" role="main">

   <?php get_template_part('partials/content-page-header'); ?>

   <div class="pxr-page-tags-wrapper pxr-wrapper pxr-page-inner">
      <div class="pxr-page-tags">
         <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

               <?php get_template_part('/post-contents/article-post', get_post_format()); ?>

            <?php endwhile;
         else : ?>
            <?php get_template_part('partials/notfound') ?>
         <?php endif; ?>
      </div>
   </div>
   <div class="pxr-pagination-wrapper">
      <?php pxr_page_links(); ?>
   </div>

</div>

<?php get_footer(); ?>