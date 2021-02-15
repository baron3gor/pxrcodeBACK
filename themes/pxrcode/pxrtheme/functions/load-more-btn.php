<?php

/**
 * Javascript for Load More
 *
 */

if (!function_exists('pxr_load_more_js')) {
   function pxr_load_more_js()
   {

      $args = array(
         'nonce'       => wp_create_nonce('pxr-load-more-nonce'),
         'url'         => admin_url('admin-ajax.php'),
         'button_text' => esc_html__('Load More', 'pxrcode'),
      );

      wp_enqueue_script(
         'pxr-load-more',
         get_stylesheet_directory_uri() . '/js/libs/load-more-btn.js',
         array('jquery'),
         '1.0',
         true
      );
      wp_localize_script('pxr-load-more', 'pxrloadmore', $args);
   }

   add_action('pxr_load_more_scripts', 'pxr_load_more_js');
}



/**
 * AJAX Load More
 *
 */
if (!function_exists('pxr_ajax_load_more')) {
   function pxr_ajax_load_more()
   {
      check_ajax_referer('pxr-load-more-nonce', 'nonce');

      $args     = pxr_ctlg_args();
      $pxr_loop = new \WP_Query($args);

      ob_start();

      if ($pxr_loop->have_posts()) : while ($pxr_loop->have_posts()) : $pxr_loop->the_post(); ?>

			<?php get_template_part('/post-contents/article', 'catalogue'); ?>

		<?php endwhile;
      endif;
      wp_reset_postdata();
      $data = ob_get_clean();
      wp_send_json_success($data);
      wp_die();
   }
}

add_action('wp_ajax_pxr_ajax_load_more', 'pxr_ajax_load_more');
add_action('wp_ajax_nopriv_pxr_ajax_load_more', 'pxr_ajax_load_more');
