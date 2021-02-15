<?php get_header(); ?>
<div class="pxr-page-404-wrapper pxr-wrapper">
   <div class="pxr-page-404">
      <div class="pxr-page-404-subtitle">
         <span><?php echo esc_html('¯\_(ツ)_/¯', 'pxrcode') ?></span>
      </div>
      <div class="pxr-page-404-title">
         <h2><?php esc_html_e('404', 'pxrcode'); ?></h2>
      </div>
      <div class="pxr-page-404-title-description">
         <p><?php echo esc_html('The page you are looking for doesn\'t seem to exist or has been moved to a new location.', 'pxrcode') ?></p>
      </div>
      <div class="pxr-btn-wrapper">
         <a href="<?php echo esc_js('javascript:history.go(-1)'); ?>" class="pxr-button-default"><?php esc_html_e('Let\'s go back', 'pxrcode'); ?></a>
      </div>
   </div>
</div>
<?php get_footer(); ?>