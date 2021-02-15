<?php

/**
 * Enqueue Theme Styles
 */

if (!function_exists('pxr_enqueue_styles')) {
   function pxr_enqueue_styles()
   {
      //Add general css files
      wp_register_style('pxr-main-css', PXR_THEME_URL . '/assets/dist/css/main.css', array(), PXR_THEME_VERSION, 'all');


      //Load general css
      wp_enqueue_style('pxr-main-css');
   }
}

add_action('wp_enqueue_scripts', 'pxr_enqueue_styles');


/**
 * Enqueue Theme Scripts
 */
if (!function_exists('pxr_enqueue_scripts')) {
   function pxr_enqueue_scripts()
   {
      // add html5 for old browsers.
      wp_register_script('html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array('jquery'), PXR_THEME_VERSION, false);

      //Custom JS Code
      wp_register_script('pxr-vendor', PXR_THEME_URL . '/assets/dist/js/vendor.js', array('jquery'), PXR_THEME_VERSION, true);
      wp_register_script('pxr-main', PXR_THEME_URL . '/assets/dist/js/main.js', array('jquery'), PXR_THEME_VERSION, true);

      wp_enqueue_script('html5-shim');
      wp_script_add_data('html5-shim', 'conditional', 'lt IE 9');

      //Load vendor + main    
      wp_enqueue_script('pxr-vendor');
      wp_enqueue_script('pxr-main');

      if (is_singular() && comments_open() && get_option('thread_comments')) {
         wp_enqueue_script('comment-reply');
      }
   }

   add_action('wp_enqueue_scripts', 'pxr_enqueue_scripts');
}


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
if (!function_exists('pxr_add_defer_attribute')) {
   function pxr_add_defer_attribute($tag, $handle)
   {
      $handles = array(
         'pxr-main',
         'pxr-vendor',
      );

      foreach ($handles as $defer_script) {
         if ($defer_script === $handle) {
            return str_replace(' src', ' defer="defer" src', $tag);
         }
      }
      return $tag;
   }

   add_filter('script_loader_tag', 'pxr_add_defer_attribute', 10, 2);
}
