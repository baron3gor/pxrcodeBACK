<?php

/**
 * Section Init = do_action('pxr_ctlg_section_action')
 * CTLG single article = get_template_part('/post-contents/article', 'catalogue')
 * 
 * $args for AJAX Sorter/AJAX Loadmore = pxr_ctlg_args()
 * 
 */

/**
 * CTLG args
 */
if (!function_exists('pxr_ctlg_args')) {
   function pxr_ctlg_args()
   {

      $pxr_page    = $_POST['page'];
      $pxr_termid  = $_POST['termid'];
      $pxr_terms   = get_terms('catalogue-category');
      $pxr_all_ids = wp_list_pluck($pxr_terms, 'term_id');

      if ($pxr_termid == '0') {
         $pxr_termid = $pxr_all_ids;
      }

      $args = array(
         'post_type'      => 'catalogue',
         'post_status'    => 'publish',
         'posts_per_page' => '1',
         'paged'          => $pxr_page,
         'tax_query' => array(
            array(
               'taxonomy' => 'catalogue-category',
               'field'    => 'term_id',
               'terms'    => $pxr_termid
            )
         )
      );

      return $args;
   }
}


/**
 * CTLG body
 */
if (!function_exists('pxr_ctlg_body')) {
   function pxr_ctlg_body($pxr_loop, $maxpage)
   { ?>
      <div data-termid="0" class="pxr-ctlg-section__articles" data-maxpage="<?php echo esc_attr($maxpage, 'pxrcode'); ?>">

         <?php if ($pxr_loop->have_posts()) : while ($pxr_loop->have_posts()) : $pxr_loop->the_post(); ?>

               <?php get_template_part('/post-contents/article', 'catalogue'); ?>

            <?php endwhile;
         else : ?>
            <?php get_template_part('partials/notfound') ?>
         <?php endif; ?>

      </div>

   <?php
   }

   add_action('pxr_ctlg_body_action', 'pxr_ctlg_body', 10, 2);
}


/**
 * CTLG Section
 */
if (!function_exists('pxr_ctlg_section')) {
   function pxr_ctlg_section()
   {

      do_action('pxr_load_more_scripts');
      do_action('pxr_sorter_scripts');

      $pxr_terms   = get_terms('catalogue-category');
      $pxr_all_ids = wp_list_pluck($pxr_terms, 'term_id');

      $args = array(
         'post_type'      => 'catalogue',
         'post_status'    => 'publish',
         'posts_per_page' => '1',
         'taxonomy'       => 'catalogue-category',
         'tax_query' => array(
            array(
               'taxonomy' => 'catalogue-category',
               'field'    => 'term_id',
               'terms'    => $pxr_all_ids
            )
         )
      );

      $pxr_loop = new \WP_Query($args);
      $maxpage  = $pxr_loop->max_num_pages; ?>

      <div class="pxr-ctlg-section">
         <div class="pxr-ctlg-section__wrapper">
            <div class="pxr-ctlg-section__filters">
               <?php foreach (get_terms('catalogue-category') as $item) : ?>

                  <span data-termid="<?php echo esc_attr($item->term_id, 'pxrcode') ?>" class="pxr-ctlg-section__sorter"><?php echo esc_html($item->name, 'pxrcode'); ?></span>

               <?php endforeach ?>
            </div>
            <div class="pxr-ctlg-section__content">
               <?php do_action('pxr_ctlg_body_action', $pxr_loop, $maxpage); ?>
            </div>
         </div>
      </div>

<?php
      wp_reset_postdata(); // сброс
   }

   add_action('pxr_ctlg_section_action', 'pxr_ctlg_section');
}
