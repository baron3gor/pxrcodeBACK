<?php

/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item
 */
if (!function_exists("pxr_register_main_options_metabox")) {
   function pxr_register_main_options_metabox()
   {

      $pxr = 'pxr_';

      /**
       * Register section theme options
       */
      $args = array(
         'id'           => $pxr . 'theme_options_page',
         'title'        => 'pxr Options',
         'object_types' => array('options-page'),
         'option_key'   => $pxr . 'theme_options',
         'tab_group'    => $pxr . 'theme_options',
         'tab_title'    => 'pxr Options',
      );
      if (version_compare(CMB2_VERSION, '2.4.0')) {
         $args['display_cb'] = 'pxr_options_display_with_tabs';
      }
      $main_options = new_cmb2_box($args);

      //Privacy Policy
      $main_options->add_field(array(
         'name' => __('Privacy Policy', 'cpt-pxr'),
         'type' => 'title',
         'id'   =>  $pxr . 'theme_options_privacy_title'
      ));

      $main_options->add_field(array(
         'name' => __('Link URL', 'cmb2'),
         'id'   => $pxr . 'link',
         'type' => 'text',
         'attributes' => array('placeholder' => __("https://example.com", 'your_textdomain')),
      ));



      /**
       * Register section footer
       */
      $args = array(
         'id'           => $pxr . 'footer_options_page',
         'menu_title'   => 'Footer',
         'title'        => 'Footer',
         'object_types' => array('options-page'),
         'option_key'   => $pxr . 'footer_options',
         'parent_slug'  => $pxr . 'theme_options',
         'tab_group'    => $pxr . 'theme_options',
         'tab_title'    => 'Footer',
      );
      if (version_compare(CMB2_VERSION, '2.4.0')) {
         $args['display_cb'] = 'pxr_options_display_with_tabs';
      }
      $footer_options = new_cmb2_box($args);

      //Test Title
      $footer_options->add_field(array(
         'name' => __('Footer Settings', 'cpt-pxr'),
         'type' => 'title',
         'id'   =>  $pxr . 'theme_options_title2'
      ));

      $group_field_id = $footer_options->add_field(array(
         'id'          => $pxr . 'main_items',
         'type'        => 'group',
         'options'     => array(
            'group_title'   => __('Item {#}', 'cpt-pxr'),
            'add_button'    => __('Add Another Item', 'cpt-pxr'),
            'remove_button' => __('Remove Item', 'cpt-pxr'),
            'sortable'      => true,
         ),
      ));

      $footer_options->add_group_field($group_field_id, array(
         'name'       => __('Card Title', 'cpt-pxr'),
         'id'         => $pxr . 'group_title',
         'type'       => 'text',
      ));

      $footer_options->add_field(array(
         'name' => 'Test Text Area for Code',
         'desc' => 'field description (optional)',
         'id'   => $pxr . 'textarea_code',
         'type' => 'textarea_code',
      ));

      $footer_options->add_field(array(
         'name'    => 'Site Background Color',
         'desc'    => 'field description (optional)',
         'id'      => $pxr . 'wsy_textarea',
         'type'    => 'wysiwyg',
         'options' => array(
            'textarea_rows' => 5
         )
      ));



      /**
       * Register section google maps
       */
      $args = array(
         'id'           => $pxr . 'googlemaps_options_page',
         'menu_title'   => 'Google Maps',
         'title'        => 'Google Maps',
         'object_types' => array('options-page'),
         'option_key'   => $pxr . 'googlemaps_options',
         'parent_slug'  => $pxr . 'theme_options',
         'tab_group'    => $pxr . 'theme_options',
         'tab_title'    => 'Google Maps',
      );
      if (version_compare(CMB2_VERSION, '2.4.0')) {
         $args['display_cb'] = 'pxr_options_display_with_tabs';
      }
      $pxr_googlemaps = new_cmb2_box($args);

      //Google maps settings
      $pxr_googlemaps->add_field(array(
         'name' => __('Google Maps Settings', 'cpt-pxr'),
         'type' => 'title',
         'id'   =>  $pxr . 'googlemaps_title'
      ));

      $pxr_googlemaps->add_field(array(
         'name' => 'Google Api Key',
         'id'   => $pxr . 'googlemap_api',
         'type' => 'text',
      ));

      $pxr_googlemaps->add_field(array(
         'name' => 'Latitude',
         'id'   => $pxr . 'googlemap_lat',
         'type' => 'text',
      ));
      $pxr_googlemaps->add_field(array(
         'name' => 'Longitude',
         'id'   => $pxr . 'googlemap_lon',
         'type' => 'text',
      ));

      $pxr_googlemaps->add_field(array(
         'name'    => 'Google Mark Color',
         'id'      => $pxr . 'google_mark',
         'type'    => 'colorpicker',
      ));

      $pxr_googlemaps->add_field(array(
         'name'    => 'Google Mark Stroke Color',
         'id'      => $pxr . 'google_mark_stroke',
         'type'    => 'colorpicker',
      ));



      /**
       * Register section performance
       */
      $args = array(
         'id'           => $pxr . 'performance_option_page',
         'menu_title'   => 'Performance',
         'title'        => 'Performance',
         'object_types' => array('options-page'),
         'option_key'   => $pxr . 'performance_options',
         'parent_slug'  => $pxr . 'theme_options',
         'tab_group'    => $pxr . 'theme_options',
         'tab_title'    => 'Performance',
      );
      if (version_compare(CMB2_VERSION, '2.4.0')) {
         $args['display_cb'] = 'pxr_options_display_with_tabs';
      }
      $pxr_performance = new_cmb2_box($args);

      //Unnecessary scripts and styles
      $pxr_performance->add_field(array(
         'name' => __('Unnecessary scripts and styles', 'cpt-pxr'),
         'type' => 'title',
         'id'   =>  $pxr . 'performance_files'
      ));

      $pxr_performance->add_field(array(
         'name'             => 'Dashicons styles and Admin bar',
         'desc'             => 'Enable/Disable',
         'id'               => $pxr . 'dashicons_show',
         'type'             => 'select',
         'default'          => 'disable',
         'options'          => array(
            'enable'  => __('Enable', 'cpt-pxr'),
            'disable' => __('Disable', 'cpt-pxr'),
         ),
      ));

      $pxr_performance->add_field(array(
         'name'             => 'Emoji',
         'desc'             => 'Enable/Disable',
         'id'               => $pxr . 'emoji_show',
         'type'             => 'select',
         'default'          => 'disable',
         'options'          => array(
            'enable'  => __('Enable', 'cpt-pxr'),
            'disable' => __('Disable', 'cpt-pxr'),
         ),
      ));

      $pxr_performance->add_field(array(
         'name'             => 'Embed Scripts',
         'desc'             => 'Enable/Disable',
         'id'               => $pxr . 'embed_show',
         'type'             => 'select',
         'default'          => 'disable',
         'options'          => array(
            'enable'  => __('Enable', 'cpt-pxr'),
            'disable' => __('Disable', 'cpt-pxr'),
         ),
      ));

      $pxr_performance->add_field(array(
         'name'             => 'Jquery Migrate Scripts',
         'desc'             => 'Enable/Disable',
         'id'               => $pxr . 'migrate_show',
         'type'             => 'select',
         'default'          => 'disable',
         'options'          => array(
            'enable'  => __('Enable', 'cpt-pxr'),
            'disable' => __('Disable', 'cpt-pxr'),
         ),
      ));

      $pxr_performance->add_field(array(
         'name'             => 'rss+xml',
         'desc'             => 'Enable/Disable',
         'id'               => $pxr . 'rssxml_show',
         'type'             => 'select',
         'default'          => 'disable',
         'options'          => array(
            'enable'  => __('Enable', 'cpt-pxr'),
            'disable' => __('Disable', 'cpt-pxr'),
         ),
      ));

      $pxr_performance->add_field(array(
         'name'             => 'Shortlinks',
         'desc'             => 'Enable/Disable',
         'id'               => $pxr . 'shortinks_show',
         'type'             => 'select',
         'default'          => 'disable',
         'options'          => array(
            'enable'  => __('Enable', 'cpt-pxr'),
            'disable' => __('Disable', 'cpt-pxr'),
         ),
      ));
   }
   add_action('cmb2_admin_init', 'pxr_register_main_options_metabox');
}

/**
 * CMB THEME OPTIONS FUNCTIONS
 */
if (!function_exists("pxr_options_display_with_tabs")) {
   function pxr_options_display_with_tabs($cmb_options)
   {
      $tabs = pxr_options_page_tabs($cmb_options); ?>

      <div class="wrap pxr-theme-options cmb2-options-page option-<?php echo $cmb_options->option_key; ?>">
         <?php if (get_admin_page_title()) : ?>
            <h2><?php echo wp_kses_post(get_admin_page_title()); ?></h2>
         <?php endif; ?>
         <h2 class="nav-tab-wrapper">

            <?php foreach ($tabs as $option_key => $tab_title) : ?>
               <a class="nav-tab<?php if (isset($_GET['page']) && $option_key === $_GET['page']) : ?> nav-tab-active<?php endif; ?>" href="<?php menu_page_url($option_key); ?>"><?php echo wp_kses_post($tab_title); ?></a>
            <?php endforeach; ?>
         </h2>
         <form class="cmb-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" id="<?php echo $cmb_options->cmb->cmb_id; ?>" enctype="multipart/form-data" encoding="multipart/form-data">
            <input type="hidden" name="action" value="<?php echo esc_attr($cmb_options->option_key); ?>">
            <?php $cmb_options->options_page_metabox(); ?>
            <?php submit_button(esc_attr($cmb_options->cmb->prop('save_button')), 'primary', 'submit-cmb'); ?>
         </form>
      </div>
<?php
   }
}


if (!function_exists("pxr_options_page_tabs")) {
   function pxr_options_page_tabs($cmb_options)
   {
      $tab_group = $cmb_options->cmb->prop('tab_group');
      $tabs      = array();

      foreach (CMB2_Boxes::get_all() as $cmb_id => $cmb) {
         if ($tab_group === $cmb->prop('tab_group')) {
            $tabs[$cmb->options_page_keys()[0]] = $cmb->prop('tab_title')
               ? $cmb->prop('tab_title')
               : $cmb->prop('title');
         }
      }

      return $tabs;
   }
}

if (!function_exists("pxr_get_option")) {
   function pxr_get_option($option_key, $field_id = '', $default = false)
   {

      $option_key = 'pxr_' . $option_key;
      $field_id = 'pxr_' . $field_id;
      return cmb2_options($option_key)->get($field_id, $default);
   }
}
