<?php

/****************************************************************
 * DO NOT DELETE
 ****************************************************************/
if (!defined('PXRTHEME_PATH')) {
   if (get_stylesheet_directory() == get_template_directory()) {
      define('PXRTHEME_PATH', get_template_directory() . '/pxrtheme');
   } else {
      define('PXRTHEME_PATH', get_theme_root() . '/pxrcode/pxrtheme');
   }
}

require_once PXRTHEME_PATH . '/init.php';
