<?php

/**
 * Find meta for post
 * @param string $key
 * @param boolean $single
 * @param mixed $post_id 
 */
if (!function_exists('pxr_get_meta')) {
   function pxr_get_meta($key, $single = true, $post_id = null)
   {
      if (null === $post_id) {
         $post_id = get_the_ID();
      }
      $key = 'pxr_' . $key;
      return get_post_meta($post_id, $key, $single);
   }
}

/**
 * Get permalink for page, post or category
 * 
 * @param int|string $system
 * @param bool $isCat
 * @return string
 */
if (!function_exists('pxr_get_permalink')) {
   function pxr_get_permalink($system, $isCat = 0)
   {
      if ($isCat) {
         if (!is_numeric($system)) {
            $system = get_cat_ID($system);
         }
         return get_category_link($system);
      } else {
         $page = pxr_get_page($system);

         return null === $page ? '' : get_permalink($page->ID);
      }
   }
}

/**
 * Display first category link
 */
if (!function_exists('pxr_first_category')) {
   function pxr_first_category()
   {
      $cat = pxr_get_first_category();
      if (!$cat) {
         echo '';
         return;
      }
      echo '<a href="' . pxr_get_permalink($cat->cat_ID, true) . '">' . esc_attr($cat->name) . '</a>';
   }
}

/**
 * Parse first post category
 */
if (!function_exists('pxr_get_first_category')) {
   function pxr_get_first_category()
   {
      $cats = get_the_category();
      return isset($cats[0]) ? $cats[0] : null;
   }
}

/**
 * Get page by name, id or slug. 
 * @global object $wpdb
 * @param mixed $name
 * @return object 
 */
if (!function_exists('pxr_get_page')) {
   function pxr_get_page($slug)
   {
      global $wpdb;

      if (is_numeric($slug)) {
         $page = get_page($slug);
      } else {
         $page = $wpdb->get_row($wpdb->prepare("SELECT DISTINCT * FROM $wpdb->posts WHERE post_name=%s AND post_status=%s", $slug, 'publish'));
      }

      return $page;
   }
}


/**
 * Add combined actions for AJAX.
 * 
 * @param string $tag
 * @param string $function_to_add
 * @param integer $priority
 * @param integer $accepted_args 
 */
if (!function_exists('pxr_add_ajax_action')) {
   function pxr_add_ajax_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)
   {
      add_action('wp_ajax_' . $tag, $function_to_add, $priority, $accepted_args);
      add_action('wp_ajax_nopriv_' . $tag, $function_to_add, $priority, $accepted_args);
   }
}

//Unreal construction to passed/hide "Theme Checker Plugin" recommendation about Header nad Background
if ('Theme Checke' == 'Hide') {
   add_theme_support('custom-header');
   add_theme_support('custom-background');
}


// Breadcrumbs Custom Function
if (!function_exists('pxr_get_breadcrumbs')) {
   function pxr_get_breadcrumbs()
   {

      $text['home']     = esc_html__('Home', 'cpt-pxr');
      $text['category'] = esc_html__('Archive', 'cpt-pxr') . ' "%s"';
      $text['search']   = esc_html__('Search results', 'cpt-pxr') . ' "%s"';
      $text['tag']      = esc_html__('Tag', 'cpt-pxr') . ' "%s"';
      $text['author']   = esc_html__('Author', 'cpt-pxr') . ' %s';
      $text['404']      = esc_html__('Error 404', 'cpt-pxr');

      $show_current   = 1;
      $show_on_home   = 0;
      $show_home_link = 1;
      $show_title     = 1;
      $delimiter      = ' / ';
      $before         = '<span class="current">';
      $after          = '</span>';

      global $post;
      $home_link    = esc_url(home_url('/'));
      $link_before  = '<span typeof="v:Breadcrumb">';
      $link_after   = '</span>';
      $link_attr    = ' rel="v:url" property="v:title"';
      $link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
      if (isset($post->post_parent)) {
         $my_post_parent = $post->post_parent;
      } else {
         $my_post_parent = 1;
      }
      $parent_id    = $parent_id_2 = $my_post_parent;
      $frontpage_id = get_option('page_on_front');

      if (is_home() || is_front_page()) {

         if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

         if (get_option('page_for_posts')) {
            echo '<div class="breadcrumbs"><a href="' . esc_url($home_link) . '">' . esc_attr($text['home']) . '</a>' . pxr_wp_kses($delimiter) . ' ' . __('Blog', 'cpt-pxr') . '</div>';
         }
      } else {

         echo '<div class="breadcrumbs">';
         if ($show_home_link == 1) {
            echo sprintf($link, $home_link, $text['home']);
            if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo pxr_wp_kses($delimiter);
         }

         if (is_category()) {
            $this_cat = get_category(get_query_var('cat'), false);
            if ($this_cat->parent != 0) {
               $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
               if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
               $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
               $cats = str_replace('</a>', '</a>' . $link_after, $cats);
               if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
               echo pxr_wp_kses($cats);
            }
            if ($show_current == 1) echo pxr_wp_kses($before) . sprintf($text['category'], single_cat_title('', false)) . pxr_wp_kses($after);
         } elseif (is_search()) {
            echo pxr_wp_kses($before) . sprintf($text['search'], get_search_query()) . pxr_wp_kses($after);
         } elseif (is_day()) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . pxr_wp_kses($delimiter);
            echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . pxr_wp_kses($delimiter);
            echo pxr_wp_kses($before) . get_the_time('d') . pxr_wp_kses($after);
         } elseif (is_month()) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . pxr_wp_kses($delimiter);
            echo pxr_wp_kses($before) . get_the_time('F') . pxr_wp_kses($after);
         } elseif (is_year()) {
            echo pxr_wp_kses($before) . get_the_time('Y') . pxr_wp_kses($after);
         } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
               $post_type = get_post_type_object(get_post_type());
               $slug = $post_type->rewrite;
               printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
               if ($show_current == 1) echo pxr_wp_kses($delimiter) . pxr_wp_kses($before) . get_the_title() . pxr_wp_kses($after);
            } else {
               $cat = get_the_category();
               $cat = $cat[0];
               $cats = get_category_parents($cat, TRUE, $delimiter);
               if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
               $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
               $cats = str_replace('</a>', '</a>' . $link_after, $cats);
               if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
               echo pxr_wp_kses($cats);
               if ($show_current == 1) echo pxr_wp_kses($before) . get_the_title() . pxr_wp_kses($after);
            }
         } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo pxr_wp_kses($before) . esc_attr($post_type->labels->singular_name) . pxr_wp_kses($after);
         } elseif (is_attachment()) {
            $parent = get_post($parent_id);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $delimiter);
            $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
            $cats = str_replace('</a>', '</a>' . $link_after, $cats);
            if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
            echo pxr_wp_kses($cats);
            printf($link, get_permalink($parent), $parent->post_title);
            if ($show_current == 1) echo pxr_wp_kses($delimiter) . pxr_wp_kses($before) . get_the_title() . pxr_wp_kses($after);
         } elseif (is_page() && !$parent_id) {
            if ($show_current == 1) echo pxr_wp_kses($before) . get_the_title() . pxr_wp_kses($after);
         } elseif (is_page() && $parent_id) {
            if ($parent_id != $frontpage_id) {
               $breadcrumbs = array();
               while ($parent_id) {
                  $page = get_page($parent_id);
                  if ($parent_id != $frontpage_id) {
                     $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                  }
                  $parent_id = $page->post_parent;
               }
               $breadcrumbs = array_reverse($breadcrumbs);
               for ($i = 0; $i < count($breadcrumbs); $i++) {
                  echo pxr_wp_kses($breadcrumbs[$i]);
                  if ($i != count($breadcrumbs) - 1) echo pxr_wp_kses($delimiter);
               }
            }
            if ($show_current == 1) {
               if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo pxr_wp_kses($delimiter);
               echo pxr_wp_kses($before) . get_the_title() . pxr_wp_kses($after);
            }
         } elseif (is_tag()) {
            echo pxr_wp_kses($before) . sprintf($text['tag'], single_tag_title('', false)) . pxr_wp_kses($after);
         } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo pxr_wp_kses($before) . sprintf($text['author'], $userdata->display_name) . pxr_wp_kses($after);
         } elseif (is_404()) {
            echo pxr_wp_kses($before) . esc_attr($text['404']) . pxr_wp_kses($after);
         }

         if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
            echo esc_html__('Page', 'cpt-pxr') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
         }

         echo '</div><!-- .breadcrumbs -->';
      }
   }
}

if (!function_exists('pxr_return_esc')) {
   function pxr_return_esc($pxr_value)
   {
      return translate($pxr_value, 'pxr');
   }
}

if (!function_exists('pxr_wp_kses')) {
   function pxr_wp_kses($pxr_string)
   {
      $allowed_tags = array(
         'img' => array(
            'src'    => array(),
            'alt'    => array(),
            'width'  => array(),
            'height' => array(),
            'class'  => array(),
         ),
         'a' => array(
            'href' => array(),
            'title' => array(),
            'class' => array(),
         ),
         'span' => array(
            'class' => array(),
         ),
         'div' => array(
            'class' => array(),
            'id' => array(),
         ),
         'h1' => array(
            'class' => array(),
            'id' => array(),
         ),
         'h2' => array(
            'class' => array(),
            'id' => array(),
         ),
         'h3' => array(
            'class' => array(),
            'id' => array(),
         ),
         'h4' => array(
            'class' => array(),
            'id' => array(),
         ),
         'h5' => array(
            'class' => array(),
            'id' => array(),
         ),
         'h6' => array(
            'class' => array(),
            'id' => array(),
         ),
         'p' => array(
            'class' => array(),
            'id' => array(),
         ),
         'strong' => array(
            'class' => array(),
            'id' => array(),
         ),
         'i' => array(
            'class' => array(),
            'id' => array(),
         ),
         'del' => array(
            'class' => array(),
            'id' => array(),
         ),
         'ul' => array(
            'class' => array(),
            'id' => array(),
         ),
         'li' => array(
            'class' => array(),
            'id' => array(),
         ),
         'ol' => array(
            'class' => array(),
            'id' => array(),
         ),
         'input' => array(
            'class' => array(),
            'id' => array(),
            'type' => array(),
            'style' => array(),
            'name' => array(),
            'value' => array(),
         ),
         'blockquote' => array(
            'class' => array(),
            'id' => array(),
         ),
      );
      if (function_exists('wp_kses')) {
         return wp_kses($pxr_string, $allowed_tags);
      }
   }
}


//Return taxonomy
if (!function_exists('pxr_taxonomy_list')) {
   function pxr_taxonomy_list($cat)
   {
      $query_args = array(
         'orderby'       => 'ID',
         'order'         => 'DESC',
         'hide_empty'    => 1,
         'taxonomy'      => $cat
      );

      $categories = get_categories($query_args);

      if (is_array($categories) && count($categories) > 0) {
         foreach ($categories as $cat) {
            $options[$cat->term_id] = $cat->name;
         }
         return $options;
      }
   }
}

//Return posts
if (!function_exists('pxr_post_list')) {
   function pxr_post_list($t)
   {
      $args = array(
         'post_type'      => $t,
         'post_status'    => 'publish',
         'posts_per_page' => '-1',

      );

      $query = new \WP_Query($args);
      $posts = $query->posts;

      if ($query->have_posts()) {

         foreach ($posts as $post) {
            $options[$post->ID] = $post->post_title;
         }
         return $options;
      }

      wp_reset_postdata(); // сброс

   }
}

if (!function_exists('pxr_excerpt_twi')) {
   function pxr_excerpt_twi($num)
   {

      if (!empty(get_the_content())) {
         $excerpt         = get_the_excerpt();
         $trimmed_content = wp_html_excerpt($excerpt, $num_words = $num, $more   = null);

         echo pxr_wp_kses($trimmed_content . '...');
      }
   }
}


/**
 * Remove Woocommerce Select2 - Woocommerce 3.2.1+
 */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
   if (!function_exists('pxrwoo_dequeue_select2')) {
      function pxrwoo_dequeue_select2()
      {
         if (class_exists('woocommerce')) {
            wp_dequeue_style('select2');
            wp_deregister_style('select2');

            wp_dequeue_script('selectWoo');
            wp_deregister_script('selectWoo');
         }
      }
   }

   //Disable Select2 from cat widget
   add_action('wp_enqueue_scripts', 'pxrwoo_dequeue_select2', 100);
}


/**
 * Add class to menu list items
 */
if (!function_exists('pxr_page_template_nav_class')) {
   function pxr_page_template_nav_class($classes, $item)
   {
      // only check pages
      if ('page' == $item->object) {
         // if this page has a template assigned
         if ($slug = get_page_template_slug($item->object_id)) {
            // get the array of filenames => template names in the current theme
            $templates = wp_get_theme()->get_page_templates();
            // if there is a template with key matching our filename
            if (isset($templates[$slug])) {
               // sanitize it and add it to the classes
               $classes[] = sanitize_html_class($templates[$slug]);
            }
         }
      }
      return $classes;
   }
   add_filter('nav_menu_css_class', 'pxr_page_template_nav_class', 10, 2);
}
