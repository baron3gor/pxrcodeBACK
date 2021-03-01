<?php

/**
 * Preload fonts
 */
if (!function_exists('pxr_preload_enqueue_scripts')) {
   function pxr_preload_enqueue_scripts()
   {
      wp_enqueue_style('pxr-icon-handle', PXR_THEME_URL . '/assets/fonts/pxriconfont/pxriconfont.woff', array(), null);
   }

   add_filter('style_loader_tag', 'pxr_font_loader_filter', 10, 2);
}

if (!function_exists('pxr_font_loader_filter')) {
   function pxr_font_loader_filter($html, $handle)
   {
      $handles = array(
         'pxr-icon-handle',
      );

      foreach ($handles as $font) {
         if ($font === $handle) {
            return str_replace(
               "rel='stylesheet'",
               "rel='preload' as='font' type='font/woff' crossorigin='anonymous'",
               $html
            );
         }
      }
      return $html;
   }

   add_action('wp_enqueue_scripts', 'pxr_preload_enqueue_scripts');
}


/**
 * ADD Defer to js
 */
if (!function_exists('pxr_add_defer_attribute') && !empty(get_option('pxr_performance_options')['pxr_defer_scripts'])) {
   function pxr_add_defer_attribute($tag, $handle)
   {
      $list = get_option('pxr_performance_options')['pxr_defer_script'];
      $list = str_replace(" ", "", $list);
      $handles  = preg_split('/\r\n|\r|\n/', $list);
      foreach ($handles as $defer_script) {
         if ($defer_script === $handle) {
            return str_replace(' src', ' defer="defer" src', $tag);
         }
      }
      return $tag;
   }

   add_filter('script_loader_tag', 'pxr_add_defer_attribute', 10, 2);
}
