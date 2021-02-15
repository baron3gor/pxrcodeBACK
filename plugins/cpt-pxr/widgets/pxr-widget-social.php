<?php
if (!defined('ABSPATH'))
   die('Direct access forbidden.');

/**
 * Creates widget with recent post thumbnail
 */
if (!class_exists('Pxrtheme_Social')) {
   class Pxrtheme_Social extends WP_Widget
   {

      function __construct()
      {
         $widget_ops = array(
            'classname'       => 'pxr-social',
            'description'    => 'Links to social networks'
         );

         parent::__construct('pxr-social', esc_html__('pxr Social', 'cpt-pxr'), $widget_ops);
      }

      public function widget($args, $instance)
      {
         global $wp_query;

         extract($args);

         $title = apply_filters('widget_title', $instance['title']);

         /* Our variables from the widget settings. */
         //$number = $instance['number'];

         /* Before widget (defined by themes). */
         echo pxr_wp_kses($before_widget);

         $facebook          = '';
         $twitter          = '';
         $google             = '';
         $pinterest          = '';
         $youtube          = '';
         $linkedin          = '';
         $behance          = '';
         $flickr             = '';
         $github             = '';
         $stumbleupon       = '';
         $tumblr             = '';
         $vimeo             = '';
         $vine             = '';
         $vk                = '';
         $yelp             = '';
         $instagram           = '';
         $social_alignment    = 'Center';

         if (isset($instance['facebook'])) {
            $facebook = $instance['facebook'];
         }
         if (isset($instance['twitter'])) {
            $twitter = $instance['twitter'];
         }
         if (isset($instance['google'])) {
            $google = $instance['google'];
         }
         if (isset($instance['pinterest'])) {
            $pinterest = $instance['pinterest'];
         }
         if (isset($instance['youtube'])) {
            $youtube = $instance['youtube'];
         }
         if (isset($instance['linkedin'])) {
            $linkedin = $instance['linkedin'];
         }
         if (isset($instance['behance'])) {
            $behance = $instance['behance'];
         }
         if (isset($instance['flickr'])) {
            $flickr = $instance['flickr'];
         }
         if (isset($instance['github'])) {
            $github = $instance['github'];
         }
         if (isset($instance['stumbleupon'])) {
            $stumbleupon = $instance['stumbleupon'];
         }
         if (isset($instance['tumblr'])) {
            $tumblr = $instance['tumblr'];
         }
         if (isset($instance['vimeo'])) {
            $vimeo = $instance['vimeo'];
         }
         if (isset($instance['vk'])) {
            $vk = $instance['vk'];
         }
         if (isset($instance['yelp'])) {
            $yelp = $instance['yelp'];
         }
         if (isset($instance['instagram'])) {
            $instagram = $instance['instagram'];
         }
         if (isset($instance['social_alignment'])) {
            $social_alignment = $instance['social_alignment'];
         }
?>

         <?php /* Display the widget title if one was input (before and after defined by themes). */
         if ($title)
            echo pxr_wp_kses($before_title) . esc_attr($title) . pxr_wp_kses($after_title);
         ?>
         <div class="footer-social-link">
            <ul>

               <?php if ($facebook != '') : ?>
                  <li><a href="<?php echo esc_url($facebook); ?>"><i class="social_facebook"></i></a></li>
               <?php endif; ?>

               <?php if ($twitter != '') : ?>
                  <li><a href="<?php echo esc_url($twitter); ?>"><i class="social_twitter"></i></a></li>
               <?php endif; ?>

               <?php if ($google != '') : ?>
                  <li><a href="<?php echo esc_url($google); ?>"><i class="social_googleplus"></i></a></li>
               <?php endif; ?>

               <?php if ($pinterest != '') : ?>
                  <li><a href="<?php echo esc_url($pinterest); ?>"><i class="social_pinterest"></i></a></li>
               <?php endif; ?>

               <?php if ($youtube != '') : ?>
                  <li><a href="<?php echo esc_url($youtube); ?>"><i class="social_youtube"></i></a></li>
               <?php endif; ?>

               <?php if ($linkedin != '') : ?>
                  <li><a href="<?php echo esc_url($linkedin); ?>"><i class="social_linkedin"></i></a></li>
               <?php endif; ?>
               <?php if ($behance != '') : ?>
                  <li><a href="<?php echo esc_url($behance); ?>"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
               <?php endif; ?>
               <?php if ($flickr != '') : ?>
                  <li><a href="<?php echo esc_url($flickr); ?>"><i class="social_flickr"></i></a></li>
               <?php endif; ?>
               <?php if ($github != '') : ?>
                  <li><a href="<?php echo esc_url($github); ?>"><i class="fa fa-github" aria-hidden="true"></i></a></li>
               <?php endif; ?>
               <?php if ($stumbleupon != '') : ?>
                  <li><a href="<?php echo esc_url($stumbleupon); ?>"><i class="fa fa-stumbleupon" aria-hidden="true"></i></a></li>
               <?php endif; ?>
               <?php if ($tumblr != '') : ?>
                  <li><a href="<?php echo esc_url($tumblr); ?>"><i class="social_tumblr"></i></a></li>
               <?php endif; ?>

               <?php if ($vimeo != '') : ?>
                  <li><a href="<?php echo esc_url($vimeo); ?>"><i class="social_vimeo"></i></a></li>
               <?php endif; ?>
               <?php if ($vk != '') : ?>
                  <li><a href="<?php echo esc_url($vk); ?>"><i class="fa fa-vk" aria-hidden="true"></i></a></li>
               <?php endif; ?>

               <?php if ($yelp != '') : ?>
                  <li><a href="<?php echo esc_url($yelp); ?>"><i class="fa fa-yelp" aria-hidden="true"></i></a></li>
               <?php endif; ?>
               <?php if ($instagram != '') : ?>
                  <li><a href="<?php echo esc_url($instagram); ?>"><i class="social_instagram"></i></a></li>
               <?php endif; ?>
            </ul>
         </div><!-- Footer social end -->

      <?php
         echo pxr_wp_kses($after_widget);
      }

      function update($old_instance, $new_instance)
      {
         $new_instance['title']          = strip_tags($old_instance['title']);
         $new_instance['facebook']       = $old_instance['facebook'];
         $new_instance['twitter']        = $old_instance['twitter'];
         $new_instance['google']         = $old_instance['google'];
         $new_instance['pinterest']      = $old_instance['pinterest'];
         $new_instance['youtube']        = $old_instance['youtube'];
         $new_instance['linkedin']       = $old_instance['linkedin'];
         $new_instance['behance']        = $old_instance['behance'];
         $new_instance['flickr']         = $old_instance['flickr'];
         $new_instance['github']         = $old_instance['github'];
         $new_instance['stumbleupon']    = $old_instance['stumbleupon'];
         $new_instance['tumblr']         = $old_instance['tumblr'];
         $new_instance['vimeo']          = $old_instance['vimeo'];
         $new_instance['vk']             = $old_instance['vk'];
         $new_instance['yelp']           = $old_instance['yelp'];
         $new_instance['instagram']      = $old_instance['instagram'];
         $new_instance['social_alignment']    = $old_instance['social_alignment'];
         return $new_instance;
      }

      function form($instance)
      {
         if (isset($instance['title'])) {
            $title = $instance['title'];
         } else {
            $title = esc_html__('Social', 'cpt-pxr');
         }

         $facebook         = '';
         $twitter          = '';
         $google           = '';
         $pinterest        = '';
         $youtube          = '';
         $linkedin         = '';
         $behance          = '';
         $flickr           = '';
         $github           = '';
         $stumbleupon      = '';
         $tumblr           = '';
         $vimeo            = '';
         $vk               = '';
         $yelp             = '';
         $instagram        = '';
         $social_alignment = 'Center';

         if (isset($instance['facebook'])) {
            $facebook = $instance['facebook'];
         }
         if (isset($instance['twitter'])) {
            $twitter = $instance['twitter'];
         }
         if (isset($instance['google'])) {
            $google = $instance['google'];
         }
         if (isset($instance['pinterest'])) {
            $pinterest = $instance['pinterest'];
         }
         if (isset($instance['youtube'])) {
            $youtube = $instance['youtube'];
         }
         if (isset($instance['linkedin'])) {
            $linkedin = $instance['linkedin'];
         }
         if (isset($instance['behance'])) {
            $behance = $instance['behance'];
         }
         if (isset($instance['flickr'])) {
            $flickr = $instance['flickr'];
         }
         if (isset($instance['github'])) {
            $github = $instance['github'];
         }
         if (isset($instance['stumbleupon'])) {
            $stumbleupon = $instance['stumbleupon'];
         }
         if (isset($instance['tumblr'])) {
            $tumblr = $instance['tumblr'];
         }
         if (isset($instance['vimeo'])) {
            $vimeo = $instance['vimeo'];
         }
         if (isset($instance['vk'])) {
            $vk = $instance['vk'];
         }
         if (isset($instance['yelp'])) {
            $yelp = $instance['yelp'];
         }
         if (isset($instance['instagram'])) {
            $instagram = $instance['instagram'];
         }
         if (isset($instance['social_alignment'])) {
            $social_alignment = $instance['social_alignment'];
         }
      ?>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('facebook')); ?>"><?php esc_html_e('Facebook:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php esc_html_e('Twitter:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('google')); ?>"><?php esc_html_e('Google Plus:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('google')); ?>" name="<?php echo esc_attr($this->get_field_name('google')); ?>" type="text" value="<?php echo esc_attr($google); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('pinterest')); ?>"><?php esc_html_e('Pinterest:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('pinterest')); ?>" name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>" type="text" value="<?php echo esc_attr($pinterest); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('youtube')); ?>"><?php esc_html_e('Youtube:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('youtube')); ?>" name="<?php echo esc_attr($this->get_field_name('youtube')); ?>" type="text" value="<?php echo esc_attr($youtube); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"><?php esc_html_e('Linkedin:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('behance')); ?>"><?php esc_html_e('behance:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('behance')); ?>" name="<?php echo esc_attr($this->get_field_name('behance')); ?>" type="text" value="<?php echo esc_attr($behance); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('flickr')); ?>"><?php esc_html_e('flickr:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr')); ?>" name="<?php echo esc_attr($this->get_field_name('flickr')); ?>" type="text" value="<?php echo esc_attr($flickr); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('github')); ?>"><?php esc_html_e('github:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('github')); ?>" name="<?php echo esc_attr($this->get_field_name('github')); ?>" type="text" value="<?php echo esc_attr($github); ?>" />
         </p>

         <p>
            <label for="<?php echo esc_attr($this->get_field_id('stumbleupon')); ?>"><?php esc_html_e('stumbleupon:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('stumbleupon')); ?>" name="<?php echo esc_attr($this->get_field_name('stumbleupon')); ?>" type="text" value="<?php echo esc_attr($stumbleupon); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('tumblr')); ?>"><?php esc_html_e('tumblr:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('tumblr')); ?>" name="<?php echo esc_attr($this->get_field_name('tumblr')); ?>" type="text" value="<?php echo esc_attr($tumblr); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('vimeo')); ?>"><?php esc_html_e('vimeo:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('vimeo')); ?>" name="<?php echo esc_attr($this->get_field_name('vimeo')); ?>" type="text" value="<?php echo esc_attr($vimeo); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('vk')); ?>"><?php esc_html_e('vk:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('vk')); ?>" name="<?php echo esc_attr($this->get_field_name('vk')); ?>" type="text" value="<?php echo esc_attr($vk); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('yelp')); ?>"><?php esc_html_e('yelp:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('yelp')); ?>" name="<?php echo esc_attr($this->get_field_name('yelp')); ?>" type="text" value="<?php echo esc_attr($yelp); ?>" />
         </p>
         <p>
            <label for="<?php echo esc_attr($this->get_field_id('instagram')); ?>"><?php esc_html_e('instagram:', 'cpt-pxr'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram')); ?>" type="text" value="<?php echo esc_attr($instagram); ?>" />
         </p>


<?php
      }
   }
}
