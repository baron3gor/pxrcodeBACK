<?php
if (!defined('ABSPATH'))
   die('Direct access forbidden.');

/**
/**
 * Most Commented Widget
 */
if (!class_exists('Pxrtheme_Latestposts_Widget')) {
   class Pxrtheme_Latestposts_Widget extends WP_Widget
   {
      /**
       * General Setup
       */
      public function __construct()
      {

         /* Widget settings. */
         $widget_ops = array(
            'classname' => 'pxr_latestposts_widget',
            'description' => 'A widget that displays your latest posts'
         );

         /* Widget control settings. */
         $control_ops = array(
            'width'      => 300,
            'height'   => 350,
            'id_base'   => 'pxr_latestposts_widget'
         );

         /* Create the widget. */
         parent::__construct('pxr_latestposts_widget', 'pxr Latest Posts', $widget_ops, $control_ops);
      }

      /**
       * Display Widget
       * @param array $args
       * @param array $instance
       */
      public function widget($args, $instance)
      {
         extract($args);

         $title = apply_filters('widget_title', $instance['title']);

         /* Our variables from the widget settings. */
         $number = $instance['number'];

         /* Before widget (defined by themes). */
         echo pxr_wp_kses($before_widget);

         // Display Widget
?>
         <?php /* Display the widget title if one was input (before and after defined by themes). */
         if ($title)
            echo pxr_wp_kses($before_title) . esc_attr($title) . pxr_wp_kses($after_title);
         ?>
         <div class="pxr-latestposts-widget">
            <div>
               <?php
               $query = new WP_Query(array(
                  'posts_per_page'      => $number,
                  'ignore_sticky_posts'   => 1,
                  'orderby'               => 'date',
               ));
               ?>
               <?php global $post;
               if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                     <div class="alelatestposts">
                        <div class="detail">
                           <span class="footer-widget-subtitle">
                              <?php echo esc_html(get_the_date()); ?>
                           </span>
                           <div class="footer-widget-latestpost-title">
                              <a href="<?php the_permalink(); ?>">
                                 <span class="title"><?php the_title(); ?></span>
                              </a>
                           </div>
                        </div>
                     </div>
               <?php endwhile;
               endif; ?>


            </div>

         </div>
         <!--blog_widget-->

      <?php

         /* After widget (defined by themes). */
         echo pxr_wp_kses($after_widget);
      }

      /**
       * Update Widget
       * @param array $new_instance
       * @param array $old_instance
       * @return array
       */
      public function update($new_instance, $old_instance)
      {
         $instance = $old_instance;

         $instance['title'] = strip_tags($new_instance['title']);
         $instance['number'] = strip_tags($new_instance['number']);

         return $instance;
      }

      /**
       * Widget Settings
       * @param array $instance
       */
      public function form($instance)
      {
         //default widget settings.
         $defaults = array(
            'title' => esc_html__('Latest Post', 'cpt-pxr'),
            'number' => 3
         );
         $instance = wp_parse_args((array) $instance, $defaults); ?>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'cpt-pxr') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo '' . $instance['title']; ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Posts to show:', 'cpt-pxr') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo '' . $instance['number']; ?>" />
         </p>
<?php
      }
   }
}
