<form class="pxr-search" role="search" method="get" id="searchform" action="<?php echo site_url() ?>">
   <fieldset>
      <div class="pxr-search-form">
         <input type="text" class="searchinput" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php esc_attr_e('Type here...', 'pxrcode') ?>" />
         <button type="submit" id="searchsubmit" class="pxr-search-submit-btn headerfont" value="<?php esc_attr_e('Search', 'pxrcode') ?>"><span class="icon_search"></span></button>
      </div>
   </fieldset>
</form>