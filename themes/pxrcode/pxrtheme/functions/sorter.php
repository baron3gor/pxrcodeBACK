<?php

/**
 * Javascript for Gallery Sorting
 *
 */

if (!function_exists('pxr_sorter_js')) {
   function pxr_sorter_js()
   {
      $args = array(
         'nonce'       => wp_create_nonce('pxr-sorter-nonce'),
         'url'         => admin_url('admin-ajax.php'),
      );
      wp_enqueue_script(
         'pxr-sorter',
         get_stylesheet_directory_uri() . '/js/libs/sorter.js',
         array('jquery'),
         '1.0',
         true
      );
      wp_localize_script('pxr-sorter', 'pxrsorter', $args);
   }
   add_action('pxr_sorter_scripts', 'pxr_sorter_js');
}



/**
 * AJAX Load More
 *
 */
if (!function_exists('pxr_ajax_sorter')) {
   function pxr_ajax_sorter()
   {
      check_ajax_referer('pxr-sorter-nonce', 'nonce');

      $args     = pxr_ctlg_args();
      $pxr_loop = new \WP_Query($args);
      $maxpage  = $pxr_loop->max_num_pages;

      ob_start();

      do_action('pxr_ctlg_body_action', $pxr_loop, $maxpage);

      wp_reset_postdata(); // сброс
      $data = ob_get_clean();
      wp_send_json_success($data);
      wp_die();
   }
}

add_action('wp_ajax_pxr_ajax_sorter', 'pxr_ajax_sorter');
add_action('wp_ajax_nopriv_pxr_ajax_sorter', 'pxr_ajax_sorter');
