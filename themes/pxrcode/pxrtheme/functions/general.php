<?php

/**
 * TGM Script code
 * Load translations for TGMPA.
 */
if (!function_exists('pxr_load_textdomain')) {
   function pxr_load_textdomain()
   {
      load_theme_textdomain('tgmpa', get_template_directory() . '/lang/tgm');
   }
}
add_action('init', 'pxr_load_textdomain', 1);


/**
 * Theme Body Class
 */
if (!function_exists('pxr_wp_body_classes')) {
   function pxr_wp_body_classes($classes)
   {

      $classes[] = 'pxr-theme-body-class';

      return $classes;
   }
   add_filter('body_class', 'pxr_wp_body_classes');
}


/**
 * Add class to articles
 */
if (!function_exists('pxr_theme_slug_post_classes')) {
   function pxr_theme_slug_post_classes($classes, $class, $post_id)
   {

      if (is_single() || is_singular('catalogue')) {
         $classes[] = 'pxr-single-article';
      } else {
         $classes[] = 'fade-animation pxr-article';
      }

      return $classes;
   }
   add_filter('post_class', 'pxr_theme_slug_post_classes', 10, 3);
}


/**
 * Init TGM Activation
 */
add_action('tgmpa_register', 'pxr_register_required_plugins');
if (!function_exists('pxr_register_required_plugins')) {
   function pxr_register_required_plugins()
   {

      /**
       * Array of plugin arrays. Required keys are name and slug.
       * If the source is NOT from the .org repo, then source is also required.
       */
      $plugins = array(

         array(
            'name'             => 'CMB2',
            'slug'             => 'cmb2',
            'force_activation' => false,
            'required'         => true,
         ),
         array(
            'name'                  => 'cpt pxr',
            'slug'                  => 'cpt-pxr',
            'source'                => get_template_directory() . '/plugins/cpt-pxr.zip',
            'required'              => true,
            'version'               => '',
            'force_activation'      => false,
            'force_deactivation'    => false,
            'external_url'          => '',
         ),
      );

      // Change this to your theme text domain, used for internationalising strings
      $theme_text_domain = 'px_retrieve_record(pxdoc, num)';

      /**
       * Array of configuration settings. Amend each line as needed.
       * If you want the default strings to be available under your own theme domain,
       * leave the strings uncommented.
       * Some of the strings are added into a sprintf, so see the comments at the
       * end of each line for what each argument will be.
       */

      $config = array(
         'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
         'default_path' => '',                      // Default absolute path to bundled plugins.
         'menu'         => 'tgmpa-install-plugins', // Menu slug.
         'parent_slug'  => 'themes.php',            // Parent menu slug.
         'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
         'has_notices'  => true,                    // Show admin notices or not.
         'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
         'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
         'is_automatic' => false,                   // Automatically activate plugins after installation or not.
         'message'      => '',                      // Message to output right before the plugins table.
      );

      tgmpa($plugins, $config);
   }
}

//Support automatic-feed-links
add_theme_support('automatic-feed-links');

// Title tag support now required 
add_action('after_setup_theme', 'pxr_theme_slug_setup');

if (!function_exists('pxr_theme_slug_setup')) {
   function pxr_theme_slug_setup()
   {
      add_theme_support('title-tag');
   }
}


/**
 * Register Sidebars
 */
add_action('widgets_init', 'pxr_theme_sidebars');
if (!function_exists('pxr_theme_sidebars')) {
   function pxr_theme_sidebars()
   {
      if (function_exists('register_sidebar')) {

         $my_sidebars = array(
            array(
               'name' => 'Blor Sidebar',
               'id' => 'pxr-blog-sidebar',
               'description' => 'Appears on Blog page',
               'before_widget' => '<div id="%1$s" class="widget %2$s">',
               'after_widget' => '</div>',
               'before_title' => '<h5 class="widget_title">',
               'after_title' => '</h5>'
            ),
            array(
               'name' => 'Footer',
               'id' => 'pxr-footer-sidebar',
               'description' => 'Appears on Footer.',
               'before_widget' => '<div id="%1$s" class="widget %2$s">',
               'after_widget' => '</div>',
               'before_title' => '<h5 class="widget_title">',
               'after_title' => '</h5>'
            ),
         );

         foreach ($my_sidebars as $sidebar) {
            $args = $sidebar;
            register_sidebar($args);
         }
      }
   }
}


/**
 * Use paginate_links()
 */
if (!function_exists('pxr_check_escape')) {
   function pxr_check_escape($output = "", $esc = false)
   {
      if ($esc) {
         $output = pxr_wp_kses($output);
      }

      return $output;
   }
}
if (!function_exists('pxr_page_links')) {
   function pxr_page_links()
   {
      global $wp_query, $wp_rewrite;
      $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

      $pagination = array(
         'base'               => '%_%',
         'format'             => '?paged=%#%',
         'total' => $wp_query->max_num_pages,
         'current' => $current,
         'show_all' => false,
         'type' => 'list',
         'prev_next' => true,
         'next_text' => '<i class="ion-ios-arrow-thin-right"></i>',
         'prev_text' => '<i class="ion-ios-arrow-thin-left"></i>'
      );

      if ($wp_rewrite->using_permalinks())
         $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');

      if (!empty($wp_query->query_vars['s']))
         $pagination['add_args'] = array('s' => get_query_var('s'));

      $pag = paginate_links($pagination);

      if (empty($pag)) {
         return;
      }

      $output = '<div class="pagination-wrapper">';
      $output .= $pag;
      $output .= '</div>';

      echo pxr_check_escape($output);
   }
}


/**
 * Default comments
 */
if (!function_exists('pxr_comment_default')) {
   function pxr_comment_default($comment, $args, $depth)
   {
      $GLOBALS['comment'] = $comment;
      extract($args, EXTR_SKIP);

      if ('div' == $args['style']) {
         $tag = 'div';
         $add_below = 'comment';
      } else {
         $tag = 'li';
         $add_below = 'div-comment';
      }
?>
      <<?php echo esc_attr($tag) ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
         <?php if ('div' != $args['style']) : ?>
            <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
            <?php endif; ?>
            <?php if ($depth > 1) { ?>
               <div class="pxr-comment-item comment2 second-level cf">
                  <div class="response"></div>
               <?php } else { ?>
                  <div class="pxr-comment-item comment1 first-level cf">
                  <?php } ?>
                  <div class="commenter-avatar">
                     <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size']); ?>
                  </div>
                  <div class="comment-box">
                     <div class="pxr-info-meta">
                        <?php printf("<h5 class='author'>" . esc_html__('%s', 'pxrcode') . "</h5>", get_comment_author_link()); ?>
                     </div>
                     <div class="info-content">
                        <?php if ($comment->comment_approved == '0') : ?>
                           <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'pxrcode') ?></em>
                           <br />
                        <?php endif; ?>
                        <?php comment_text() ?>
                     </div>
                     <?php if ($depth == 1) { ?><span class="pxr-reply-link"><?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span><?php } ?>
                  </div>
                  </div>
                  <?php if ('div' != $args['style']) : ?>
               </div>
            <?php endif; ?>
      <?php
   }
}
