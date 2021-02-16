<?php

/**
 * Initialize Theme Support Features 
 */
if (!function_exists('pxr_init_theme_support')) {
   function pxr_init_theme_support()
   {
      if (function_exists('pxr_get_images_sizes')) {
         foreach (pxr_get_images_sizes() as $post_type => $sizes) {
            foreach ($sizes as $config) {
               pxr_add_image_size($post_type, $config);
            }
         }
      }
   }
   add_action('init', 'pxr_init_theme_support');
}


if (!function_exists('pxr_after_setup_theme')) {
   function pxr_after_setup_theme()
   {
      // add editor style for admin editor
      add_editor_style();

      // add post thumbnails support
      add_theme_support('post-thumbnails');

      // add needed post formats to theme
      if (function_exists('pxr_get_post_formats')) {
         add_theme_support('post-formats', pxr_get_post_formats());
      }
   }
   add_action('after_setup_theme', 'pxr_after_setup_theme');
}


/**
 * Add custom image size wrapper
 */
if (!function_exists('pxr_add_image_size')) {
   function pxr_add_image_size($post_type, $config)
   {
      add_image_size($config['name'], $config['width'], $config['height'], $config['crop']);
   }
}


/**
 * Remove recentcomments inline style
 */
if (!function_exists('pxr_remove_recentcomments')) {
   function pxr_remove_recentcomments()
   {
      global $wp_widget_factory;
      remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
   }
   add_action('widgets_init', 'pxr_remove_recentcomments');
}
