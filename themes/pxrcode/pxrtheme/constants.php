<?php

/****************************************************************
 * System Functions
 ****************************************************************/

/**
 * Load Theme Variable Data
 * @param string $var
 * @return string 
 */
if (!function_exists('pxr_theme_data_variable')) {
   function pxr_theme_data_variable($var)
   {
      if (!is_file(STYLESHEETPATH . '/style.css')) {
         return '';
      }

      $theme_data = wp_get_theme();
      return $theme_data->{$var};
   }
}

/****************************************************************
 * Define Constants
 ****************************************************************/

if (!defined('PXR_THEME_VERSION')) {
   define('PXR_THEME_VERSION', pxr_theme_data_variable('Version'));
}
if (!defined('PXR_THEME_URL')) {
   define("PXR_THEME_URL", get_template_directory_uri());
}


/****************************************************************
 * Require Needed Files & Libraries
 ****************************************************************/

require_once(PXRTHEME_PATH . '/front.php');
require_once(PXRTHEME_PATH . '/functions/system.php');
require_once(PXRTHEME_PATH . '/functions/ctlg.php');
require_once(PXRTHEME_PATH . '/functions/general.php');
require_once(PXRTHEME_PATH . '/functions/custom-fnc.php');
require_once(PXRTHEME_PATH . '/functions/class-tgm-plugin-activation.php');
require_once(PXRTHEME_PATH . '/functions/loadmore-ctlg.php');
require_once(PXRTHEME_PATH . '/functions/sorter-ctlg.php');
