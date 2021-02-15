<?php
if (!defined('ABSPATH'))
   die('Direct access forbidden.');

/**
/**
 * Blog Widget 
 */
if (!class_exists('Pxrtheme_Spacer_Widget')) {
   class Pxrtheme_Spacer_Widget extends WP_Widget
   {
      /**
       * General Setup 
       */
      public function __construct()
      {

         /* Widget settings. */
         $widget_ops = array(
            'classname' => 'pxr_spacer_widget',
            'description' => esc_html__('A widget that displays spacer.', 'pxrcode')
         );

         /* Create the widget. */
         parent::__construct('pxr_spacer_widget', esc_html__('pxr Spacer', 'pxrcode'), $widget_ops);
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
         $height = $instance['height'];


         /* Before widget (defined by themes). */
         echo pxr_wp_kses($before_widget);

         // Display Widget
?>
         <?php
         if ($title)
            echo pxr_wp_kses($before_title) . esc_attr($title) . pxr_wp_kses($after_title);
         if ($height) : ?>
            <div class="pxr-spacer-widget" <?php echo pxr_wp_kses('style="height: ' . $height . 'px"') ?>></div>
         <?php endif;

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
         $instance['height'] = strip_tags($new_instance['height']);

         return $instance;
      }

      /**
       * Widget Settings
       * @param array $instance 
       */
      public function form($instance)
      {
         //default widget settings.
         $instance = wp_parse_args((array) $instance);

         $pxr_title = '';
         $pxr_height = '';

         if (isset($instance['title'])) {
            $pxr_title = $instance['title'];
         }
         if (isset($instance['height']) && is_numeric($instance['height'])) {
            $pxr_height = $instance['height'];
         } ?>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'cpt-pxr') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($pxr_title, 'cpt-pxr'); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('height')); ?>"><?php esc_html_e('Height:', 'cpt-pxr') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('height')); ?>" name="<?php echo esc_attr($this->get_field_name('height')); ?>" value="<?php echo esc_attr($pxr_height, 'cpt-pxr'); ?>" />
         </p>
<?php
      }
   }
}
