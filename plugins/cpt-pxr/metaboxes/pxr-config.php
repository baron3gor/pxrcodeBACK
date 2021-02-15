<?php

/**
 * Get current meta options
 * 
 * @return array
 */

if (defined('CMB2_LOADED')) {
   /**
    * Add Metaboxes
    * @param array $meta_boxes
    * @return array 
    */

   add_action('cmb2_admin_init', 'pxr_cmb2_metaboxes');
   /**
    * Define the metabox and field configurations.
    */
   if (!function_exists('pxr_cmb2_metaboxes')) {
      function pxr_cmb2_metaboxes()
      {

         $pxr = 'pxr_';

         /**
          * Initiate the metabox
          */
         $pxr_info = new_cmb2_box(array(
            'id'            => $pxr . 'main-section',
            'title'         => __('Main Section', 'cpt-pxr'),
            'object_types'  => array('page',), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
            //'closed'     => true, // Keep the metabox closed by default
         ));

         $pxr_info->add_field(array(
            'name'    => 'Site Background Color',
            'desc'    => 'field description (optional)',
            'id'      => $pxr . 'sec_tt',
            'type'    => 'wysiwyg',
            'default' => '',
            'options' => array(
               'textarea_rows' => 11
            )
         ));

         $pxr_info->add_field(array(
            'name'    => 'Test File',
            'desc'    => 'Upload an image or enter an URL.',
            'id'      => $pxr . 'wiki_test_image',
            'type'    => 'file',
         ));

         $pxr_info->add_field(array(
            'name'    => 'Категории',
            'id'      => $pxr . 'pxr_page_home_cases_select_term',
            'type'    => 'pw_multiselect',
            'options' => array(
               'check1' => 'Check One',
               'check2' => 'Check Two',
               'check3' => 'Check Three',
            ),
         ));

         $pxr_info->add_field(array(
            'name' => __('Select Font Awesome Icon', 'cmb'),
            'id'   => $pxr . 'iconselect',
            'desc' => 'Select Font Awesome icon',
            'type' => 'faiconselect',
            'options' => array(
               'pxr-icon-pdf' => 'pxr-icon-pdf',
               'pxr-icon-close'      => 'pxr-icon-close',
               'pxr-icon-basket'    => 'pxr-icon-basket',
            ),
            'attributes' => array(
               'faver' => 3
            )
         ));


         // Add other metaboxes as needed
      }
   }
}
