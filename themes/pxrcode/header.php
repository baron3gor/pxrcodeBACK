<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
   <meta charset="<?php bloginfo('charset'); ?>" />
   <meta name="viewport" content="width=device-width,initial-scale=1.0">
   <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
   <?php wp_body_open(); ?>
   <div class="pxr-main-site-wrapper">
      <div class="pxr-main-site-container">
         <section class="pxr-side-mobile">
            <div>
               <div class="pxr-side-mobile__close">X</div>
               <aside class="pxr-side-mobile__wrapper">
                  <?php if (has_nav_menu('pxr_mobile_menu')) { ?>
                     <?php wp_nav_menu(array(
                        'theme_location'  => 'pxr_mobile_menu',
                        'menu'            => 'Mobile Menu',
                        'menu_class'      => 'pxr-mobile-navigation-list',
                        'walker'          => new pxrframework_menu_walker,
                        'container'       => 'nav',
                        'container_class' => 'pxr-mobile-nav-wrapper',
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'container_id'    => '',
                     )); ?>
                  <?php } ?>
               </aside>
            </div>
         </section>
         <div class="pxr-main-site">
            <header class="pxr-header-wrapper">
               <div class="pxr-header-top-line">
                  <div class="pxr-header-top-line__wrapper pxr-wrapper">
                     <div class="pxr-header-top-line__logo">
                        <a href="<?php echo esc_url(home_url("/")); ?>">
                           <h1><?php esc_html(bloginfo('title')); ?></h1>
                        </a>
                     </div>
                     <?php if (has_nav_menu('pxr_header_menu')) { ?>
                        <?php
                        wp_nav_menu(array(
                           'theme_location'  => 'pxr_header_menu',
                           'menu'            => 'Header Menu',
                           'menu_class'      => 'pxr-header-navigation-list',
                           'walker'          => new pxrframework_menu_walker,
                           'container'       => 'nav',
                           'container_class' => 'pxr-header-top-line__nav',
                           'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                           'container_id'    => '',
                        )); ?>
                     <?php } ?>
                     <div class="pxr-header-top-line__icon">
                        <span class="pxr-header-top-line__btn">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
                              <circle fill="#4e413b" cx="4" cy="12" r="2" />
                              <circle fill="#4e413b" cx="12" cy="12" r="2" />
                              <circle fill="#4e413b" cx="20" cy="12" r="2" />
                           </svg>
                        </span>
                     </div>
                  </div>
               </div>
               <div class="pxr-sticky-top-line">
                  <div class="pxr-sticky-top-line__wrapper pxr-wrapper">
                     <div class="pxr-sticky-top-line__logo">
                        <a href="<?php echo esc_url(home_url("/")); ?>">
                           <h1><?php esc_html(bloginfo('title')); ?></h1>
                        </a>
                     </div>
                     <?php if (has_nav_menu('pxr_sticky_menu')) { ?>
                        <?php wp_nav_menu(array(
                           'theme_location'  => 'pxr_sticky_menu',
                           'menu'            => 'sticky Menu',
                           'menu_class'      => 'pxr-sticky-navigation-list',
                           'walker'          => new pxrframework_menu_walker,
                           'container'       => 'nav',
                           'container_class' => 'pxr-sticky-top-line__nav',
                           'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                           'container_id'    => '',
                        )); ?>
                     <?php } ?>
                     <div class="pxr-sticky-top-line__icon">
                        <span class="pxr-sticky-top-line__btn">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
                              <circle fill="#4e413b" cx="4" cy="12" r="2" />
                              <circle fill="#4e413b" cx="12" cy="12" r="2" />
                              <circle fill="#4e413b" cx="20" cy="12" r="2" />
                           </svg>
                        </span>
                     </div>
                  </div>
               </div>
            </header>
            <div class="pxr-site-content-wrapper">