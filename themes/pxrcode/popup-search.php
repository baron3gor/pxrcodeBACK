<div class="pxr-popup-search">
   <form method="get" action="<?php echo esc_url(home_url('/')); ?>/" class="wp-search-form pxr_form">
      <ul>
         <li><input type="text" class='search pop-up-search' placeholder="<?php esc_attr_e("Type Your Search", "pxrcode"); ?>" name="s" /><span class="ion-ios-search"></span><span class="search-bottom-line"></span></li>
      </ul>
      <?php if (defined("ICL_LANGUAGE_CODE")) : ?><input type="hidden" name="lang" value="<?php echo esc_attr(ICL_LANGUAGE_CODE); ?>" /><?php endif; ?>
   </form>
</div>