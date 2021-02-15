<?php
/*
*Template for display all single posts
*/

get_header();  ?>

<div class="pxr-page" role="main">

   <?php get_template_part('partials/content-page-header'); ?>

   <div class="pxr-page-single-wrapper pxr-wrapper pxr-page-inner">
      <div class="pxr-page-single">
         <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

               <?php get_template_part('/post-contents/single-article-post', get_post_format()); ?>

         <?php endwhile;
         else :
            get_template_part('partials/notfound');
         endif; ?>
      </div>
      <?php if (is_active_sidebar('pxr-blog-sidebar')) { ?>
         <aside class="pxr-sidebar-aside">
            <?php dynamic_sidebar('pxr-blog-sidebar'); ?>
         </aside>
      <?php } ?>
      <?php if (comments_open() || get_comments_number()) : ?>
         <?php comments_template(); ?>
      <?php endif; ?>
   </div>

</div>

<?php get_footer(); ?>