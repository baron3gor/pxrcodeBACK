<?php

/**
 *
 * Template Name: pxr Homepage
 */

get_header(); ?>

<div class="pxr-page" role="main">

   <?php get_template_part('partials/content-page-header'); ?>

   <div class="pxr-fullwidth-template-wrapper pxr-wrapper">
      <div class="pxr-fullwidth-template">
         <?php while (have_posts()) : the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
               <?php the_content(); ?>
            </div>
         <?php endwhile; ?>
      </div>
   </div>

</div>

<?php get_footer(); ?>