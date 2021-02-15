<article <?php post_class(); ?>>
   <?php if (has_post_thumbnail()) : ?>
      <figure>
         <?php the_post_thumbnail(); ?>
      </figure>
   <?php endif; ?>
   <div class="pxr-article__title">
      <h4><?php echo esc_html(get_the_title(), 'pxrcode') ?></h4>
   </div>
   <?php if (!empty(get_the_content())) : ?>
      <div class="pxr-article__excerpt">
         <?php echo esc_html(pxr_excerpt_twi('20'), 'pxrcode') ?>
      </div>
   <?php endif ?>
</article>