<?php

/**
 * Plugin Name: cpt pxr
 * Description: pxr Framework
 * Author: pixrow.co
 * Version: 1.0
 * Author URI: https://pixrow.co
 * Text Domain: cpt-pxr
 * cpt-pxr is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * cpt-pxr is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */


define('PXR_CORE_PLUGIN', __FILE__);
define('PXR_CORE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PXR_CORE_PLUGIN_DIR', untrailingslashit(dirname(PXR_CORE_PLUGIN)));
define('PXR_CORE_VERSION', '1.0');
define('PXR_CORE_PLUGIN_NAME', 'cpt-pxr');

//Functions
require_once('admin/pxr-admin.php');
require_once('functions/pxr-general.php');
require_once('functions/pxr-nav.php');
require_once('functions/pxr-googlemaps.php');

//Metaboxes
if (defined('CMB2_LOADED')) {
   require_once('includes/cmb-field-icons.php');
   require_once('includes/cmb-field-select2.php');
   require_once('metaboxes/pxr-config.php');
   require_once('options/pxr-options.php');
}

//Widgets
require_once('widgets/pxr-widget-latestposts.php');
require_once('widgets/pxr-widget-social.php');
require_once('widgets/pxr-widget-spacer.php');
require_once('widgets/pxr-widgets.php');


/**
 * Add Needed Post Types
 */
if (!function_exists('pxr_init_post_types')) {
   function pxr_init_post_types()
   {
      if (function_exists('pxrtheme_get_post_types')) {
         foreach (pxrtheme_get_post_types() as $type => $options) {
            pxr_add_post_type($type, $options['config'], $options['singular'], $options['multiple']);
         }
      }
   }
}
add_action('init', 'pxr_init_post_types');


/**
 * Add Needed Taxonomies
 */
if (!function_exists('pxr_init_taxonomies')) {
   function pxr_init_taxonomies()
   {
      if (function_exists('pxrtheme_get_taxonomies')) {
         foreach (pxrtheme_get_taxonomies() as $type => $options) {
            pxr_add_taxonomy($type, $options['for'], $options['config'], $options['singular'], $options['multiple']);
         }
      }
   }
}
add_action('init', 'pxr_init_taxonomies');


/**
 * Register Post Type Wrapper
 */
if (!function_exists('pxr_add_post_type')) {
   function pxr_add_post_type($name, $config, $singular = 'Entry', $multiple = 'Entries')
   {
      if (!isset($config['labels'])) {
         $config['labels'] = array(
            'name'              => $multiple,
            'singular_name'     => $singular,
            'not_found'         => 'No ' . $multiple . ' Found',
            'not_found_in_trash' => 'No ' . $multiple . ' found in Trash',
            'edit_item'         => 'Edit ', $singular,
            'search_items'      => 'Search ' . $multiple,
            'view_item'         => 'View ', $singular,
            'new_item'          => 'New ' . $singular,
            'add_new'           => 'Add New',
            'add_new_item'      => 'Add New ' . $singular,
         );
      }

      register_post_type($name, $config);
   }
}


/**
 * Register taxonomy wrapper
 */
if (!function_exists('pxr_add_taxonomy')) {
   function pxr_add_taxonomy($name, $object_type, $config, $singular = 'Entry', $multiple = 'Entries')
   {

      if (!isset($config['labels'])) {
         $config['labels'] = array(
            'name'              => $multiple,
            'singular_name'     => $singular,
            'search_items'      =>  'Search ' . $multiple,
            'all_items'         => 'All ' . $multiple,
            'parent_item'       => 'Parent ' . $singular,
            'parent_item_colon' => 'Parent ' . $singular . ':',
            'edit_item'         => 'Edit ' . $singular,
            'update_item'       => 'Update ' . $singular,
            'add_new_item'      => 'Add New ' . $singular,
            'new_item_name'     => 'New ' . $singular . ' Name',
            'menu_name'         => $singular,
         );
      }

      register_taxonomy($name, $object_type, $config);
   }
}


/**
 * Add post types that are used in the theme
 */
if (!function_exists('pxrtheme_get_post_types')) {
   function pxrtheme_get_post_types()
   {
      return array(
         'catalogue' => array(
            'config' => array(
               'public'        => true,
               'menu_position' => 20,
               'has_archive'   => true,
               'supports'      => array(
                  'title',
                  'editor',
                  'thumbnail',
               ),
               'show_in_nav_menus' => true,
            ),
            'singular' => 'Catalogue',
            'multiple' => 'Catalogue',
         ),
      );
   }
}


/**
 * Add taxonomies that are used in theme
 */
if (!function_exists('pxrtheme_get_taxonomies')) {
   function pxrtheme_get_taxonomies()
   {
      return array(
         'catalogue-category' => array(
            'for'    => array('catalogue'),
            'config' => array(
               'sort'         => true,
               'args'         => array('orderby' => 'term_order'),
               'hierarchical' => true,
            ),
            'singular'    => 'Category',
            'multiple'    => 'Categories',
         ),
      );
   }
}


/**
 * Add post formats that are used in theme
 */
if (!function_exists('pxr_get_post_formats')) {
   function pxr_get_post_formats()
   {
      return array('gallery', 'video', 'audio', 'quote', 'link');
   }
}


/**
 * Get image sizes for images
 */
if (!function_exists('pxr_get_images_sizes')) {
   function pxr_get_images_sizes()
   {
      return array(

         'post' => array(
            array(
               'name'      => 'post-grid2',
               'width'     => 836,
               'height'    => 520,
               'crop'      => true,
            ),
         ),

         'catalogue' => array(
            array(
               'name'      => 'catalogue-gallery',
               'width'     => 826,
               'height'    => 550,
               'crop'      => true,
            ),
         ),
      );
   }
}


/**
 * Initialize Theme Navigation 
 */
if (!function_exists('pxr_init_navigation')) {
   function pxr_init_navigation()
   {
      if (function_exists('register_nav_menus')) {
         register_nav_menus(array(
            'pxr_header_menu'   => esc_html__('Header Menu', 'cpt-pxr'),
            'pxr_sticky_menu'   => esc_html__('Sticky Menu', 'cpt-pxr'),
            'pxr_mobile_menu'   => esc_html__('Mobile Menu', 'cpt-pxr'),
         ));
      }
   }
   add_action('init', 'pxr_init_navigation');
}


/**
 * Disable dashicons and admin bar
 */
if (isset(get_option('pxr_performance_options')['pxr_dashicons_show']) && get_option('pxr_performance_options')['pxr_dashicons_show'] == 'enable') {
   $pxr_dashicons_show = true;
}
if (!isset($pxr_dashicons_show)) {
   add_filter('show_admin_bar', '__return_false');
   remove_action('init', 'wp_admin_bar_init');
}
if (!function_exists('pxr_adbar_deregister_styles') && !isset($pxr_dashicons_show)) {
   function pxr_adbar_deregister_styles()
   {
      wp_deregister_style('dashicons');
   }
   add_action('wp_print_styles', 'pxr_adbar_deregister_styles', 100);
}


/**
 * Disable emojis in WordPress
 */
if (isset(get_option('pxr_performance_options')['pxr_emoji_show']) && get_option('pxr_performance_options')['pxr_emoji_show'] == 'enable') {
   $pxr_emoji_show = true;
}
if (!function_exists('pxr_disable_emojis') && !isset($pxr_emoji_show)) {
   function pxr_disable_emojis()
   {
      remove_action('wp_head', 'print_emoji_detection_script', 7);
      remove_action('admin_print_scripts', 'print_emoji_detection_script');
      remove_action('wp_print_styles', 'print_emoji_styles');
      remove_filter('the_content_feed', 'wp_staticize_emoji');
      remove_action('admin_print_styles', 'print_emoji_styles');
      remove_filter('comment_text_rss', 'wp_staticize_emoji');
      remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
      add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
   }
   add_action('init', 'pxr_disable_emojis');
}

if (!function_exists('disable_emojis_tinymce') && !isset($pxr_emoji_show)) {
   function disable_emojis_tinymce($plugins)
   {
      if (is_array($plugins)) {
         return array_diff($plugins, array('wpemoji'));
      } else {
         return array();
      }
   }
}


/**
 * Remove wp-embed.min.js
 */
if (isset(get_option('pxr_performance_options')['pxr_embed_show']) && get_option('pxr_performance_options')['pxr_embed_show'] == 'enable') {
   $pxr_embed_show = true;
}
if (!function_exists('pxr_embed_deregister_scripts') && !isset($pxr_embed_show)) {
   function pxr_embed_deregister_scripts()
   {
      wp_deregister_script('wp-embed');
   }
   add_action('wp_footer', 'pxr_embed_deregister_scripts');

   add_action('init', function () {

      remove_action('rest_api_init', 'wp_oembed_register_route');
      remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
      remove_action('wp_head', 'wp_oembed_add_discovery_links');
      remove_action('wp_head', 'wp_oembed_add_host_js');
   }, PHP_INT_MAX - 1);
}


/**
 * Remove Jquery migrate
 */
if (isset(get_option('pxr_performance_options')['pxr_migrate_show']) && get_option('pxr_performance_options')['pxr_migrate_show'] == 'enable') {
   $pxr_migrate_show = true;
}
if (!function_exists('pxr_dequeue_jquery_migrate') && !isset($pxr_migrate_show)) {
   function pxr_dequeue_jquery_migrate($scripts)
   {
      if (!is_admin() && !empty($scripts->registered['jquery'])) {
         $scripts->registered['jquery']->deps = array_diff(
            $scripts->registered['jquery']->deps,
            ['jquery-migrate']
         );
      }
   }
   add_action('wp_default_scripts', 'pxr_dequeue_jquery_migrate');
}


/**
 * Remove application/rss+xml
 */
if (isset(get_option('pxr_performance_options')['pxr_rssxml_show']) && get_option('pxr_performance_options')['pxr_rssxml_show'] == 'enable') {
   $pxr_rssxml_show = true;
}
if (!isset($pxr_rssxml_show)) {
   remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
   remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
   remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
   remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
   remove_action('wp_head', 'index_rel_link'); // index link
   remove_action('wp_head', 'parent_post_rel_link', 10, 0); // prev link
   remove_action('wp_head', 'start_post_rel_link', 10, 0); // start link
   remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
   remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
}


/**
 * Remove shortlinks
 */
if (isset(get_option('pxr_performance_options')['pxr_shortinks_show']) && get_option('pxr_performance_options')['pxr_shortinks_show'] == 'enable') {
   $pxr_shortinks_show = true;
}
if (!isset($pxr_shortinks_show)) {
   remove_action('wp_head', 'wp_shortlink_wp_head');
}
