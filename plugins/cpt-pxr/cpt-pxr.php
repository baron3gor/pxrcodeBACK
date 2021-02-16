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
require_once('functions/pxr-front.php');
require_once('functions/pxr-html-minify.php');
require_once('functions/pxr-clear.php');

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
