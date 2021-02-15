<?php get_header(); ?>

<div class="pxr-page" role="main">

   <?php get_template_part('partials/content-page-header'); ?>

   <div class="pxr-page-default-wrapper pxr-wrapper pxr-page-inner">
      <div class="pxr-page-default">
         <div class="pxr-page-default-content">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                  <?php if (has_post_thumbnail()) : ?>
                     <div class="pxr-page-default-thumb-wrapper">
                        <?php the_post_thumbnail(); ?>
                     </div>
                  <?php endif; ?>
                  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                     <?php the_content(); ?>
                  </div>
               <?php endwhile;
            else : ?>
               <?php get_template_part('partials/notfound') ?>
            <?php endif; ?>
         </div>

         <?php if (comments_open() || get_comments_number()) : ?>
            <?php comments_template(); ?>
         <?php endif; ?>
      </div>
   </div>

</div>

<?php get_footer(); ?>