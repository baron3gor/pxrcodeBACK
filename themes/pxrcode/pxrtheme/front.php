<?php

/**
 * Preload fonts + defer scripts
 * plugin cpt-pxr -> functions -> pxr-front.php
 */

/**
 * Enqueue Theme Styles
 */
if (!function_exists('pxr_enqueue_styles')) {
   function pxr_enqueue_styles()
   {
      //Register main css files
      wp_register_style('pxr-main-style', PXR_THEME_URL . '/assets/dist/css/main.css', array(), PXR_THEME_VERSION, 'all');

      //Load main css
      wp_enqueue_style('pxr-main-style');
   }

   add_action('wp_enqueue_scripts', 'pxr_enqueue_styles');
}


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
