<article <?php post_class(); ?>>
   <?php if (has_post_thumbnail()) : ?>
      <figure>
         <?php the_post_thumbnail(); ?>
      </figure>
   <?php endif; ?>
   <div class="pxr-single-article__title">
      <h2><?php echo esc_html(get_the_title(), 'pxrcode') ?></h2>
   </div>
   <?php if (!empty(get_the_content())) : ?>
      <div class="pxr-single-article__content">
         <?php the_content(); ?>
      </div>
   <?php endif ?>
   <?php if (has_tag()) : ?>
      <div class="pxr-single-article__tags">
         <?php the_tags() ?>
      </div>
   <?php endif ?>
</article>