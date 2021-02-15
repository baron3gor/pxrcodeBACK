<?php

/**
 * Icon select
 */

class CMBS_SerkanA_Plugin_IConSelectFA
{

   const VERSION = '1.4';

   public function __construct()
   {
      add_filter('cmb2_render_faiconselect', array($this, 'render_faiconselect'), 10, 5);
   }

   public function render_faiconselect($field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object)
   {
      $this->Sesetup_my_cssjs($field);

      if (version_compare(CMB2_VERSION, '2.2.2', '>=')) {
         $field_type_object->type = new CMB2_Type_Select($field_type_object);
      }

      echo $field_type_object->select(
         array(
            'class'   => 'iconselectfa',
            'desc'    => $field_type_object->_desc(true),
            'options' => '<option></option>' . $field_type_object->concat_items(),
         )
      );
   }

   public function Sesetup_my_cssjs($field)
   {
      $asset_path = apply_filters('sa_cmb2_field_faiconselect_asset_path', plugins_url('', __FILE__));

      wp_enqueue_style('jqueryfontselectormain', PXR_CORE_PLUGIN_URL . '/assets/css/icons/jquery.fonticonpicker.min.css', array(), self::VERSION);
      wp_enqueue_style('jqueryfontselector', PXR_CORE_PLUGIN_URL . '/assets/css/icons/jquery.fonticonpicker.grey.min.css', array(), self::VERSION);
      wp_enqueue_script('jqueryfontselector', PXR_CORE_PLUGIN_URL . '/assets/js/icons/jquery.fonticonpicker.min.js', array('jquery'), self::VERSION, true);
      wp_enqueue_script('mainjsiselect', PXR_CORE_PLUGIN_URL . '/assets/js/icons/main.js', array('jqueryfontselector'), self::VERSION, true);
   }
}

function returnRayFaPre()
{
   include 'predefined-array-fontawesome.php';
   return $fontAwesome;
}

function returnRayFapsa()
{
   include 'predefined-array-fontawesome.php';

   $fa5a = array_combine($fa5all, $fa5all);

   return $fa5a;
}


new CMBS_SerkanA_Plugin_IConSelectFA();
