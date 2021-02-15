<?php
if (!class_exists('pxrframework_menu_walker')) {
   class pxrframework_menu_walker extends Walker_Nav_Menu
   {

      function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
      {

         if (!is_object($args)) {
            return;
         }

         global $first_item_counter;
         if (!isset($first_item_counter)) $first_item_counter = 0;

         $classes     = empty($item->classes) ? array() : (array) $item->classes;

         $class_names = join(
            ' ',
            apply_filters(
               'nav_menu_css_class',
               array_filter($classes),
               $item
            )
         );

         // find multi column class name and find the column count       
         $re = '/(multicolumn-)+(\d)/U';
         $matches  = preg_grep($re, $classes);

         $column_count = isset($matches) && is_array($matches) && count($matches) > 0 ? explode("-", reset($matches)) : array(1 => 0);
         $column_count = is_array($column_count) ? $column_count[1] : $column_count;


         if ($depth == 0) {
            $class_names = (0 < $column_count) ? $class_names . ' multicolumn ' : $class_names;
         }

         $sub_title = esc_attr($item->description);
         $title = apply_filters('the_title', $item->title, $item->ID);

         //add class name to li if item has description 
         $class_names .= !empty($sub_title) ? " has-sub-title" : "";

         //find if an icon used as class name - remove from li - use for a 
         if (!empty($class_names)) {

            if (strpos($class_names, "icon-") !== false) {

               $new_class_names = "";
               $icon_name = "";

               foreach (explode(" ", $class_names) as $value) {
                  if (strpos($value, "icon-") === false) {
                     $new_class_names .= " " . $value;
                  } else {
                     $icon_name = $value;
                  }
               }

               $class_names = ' class="' . esc_attr(trim($new_class_names)) . '"';
            } else {
               $class_names = ' class="' . esc_attr(trim($class_names)) . '"';
            }
         }

         //menu item id
         if ($args->menu_id == "mobile-navigation") {
            $element_id = 'mobile-menu-item-' . $item->ID;
         } elseif ($args->menu_id == "sticky-navigation") {
            $element_id = 'sticky-navigation-item-' . $item->ID;
         } elseif ($args->menu_id == "sticky-left") {
            $element_id = 'sticky-left-item-' . $item->ID;
         } else {
            $element_id = 'menu-item-' . $item->ID;
         }

         $class_names = trim($class_names);

         $output .= (0 == $depth && 0 < $column_count) ? "<li id='$element_id' data-col-size='$column_count' data-depth='$depth' $class_names>" :  "<li id='$element_id' data-depth='$depth' $class_names>";


         //title wrapper
         if (
            $depth == 0
         ) {
            if (!empty($icon_name)) {
               $wrapper_format = !is_rtl() ? '<span><i class="%1$s"></i>%2$s</span>' : '<span>%2$s<i class="%1$s"></i></span>';
               $title = sprintf($wrapper_format, esc_attr($icon_name), $title);
               $icon_name = "";
            } else {
               $wrapper_format = '<span>%s</span>';
               $title = sprintf($wrapper_format, $title);
            }
         } else {
            if (!empty($icon_name)) {
               $wrapper_format = !is_rtl() ? '<i class="%1$s"></i>%2$s' : '%2$s<i class="%1$s"></i>';
               $title = sprintf($wrapper_format, esc_attr($icon_name), $title);
               $icon_name = "";
            }
         }


         // attributes
         $attributes  = '';

         !empty($icon_name)
            and $attributes .= ' class="'  . esc_attr($icon_name) . '"';

         !empty($item->attr_title)
            and $attributes .= ' title="'  . esc_attr($item->attr_title) . '"';

         !empty($item->target)
            and $attributes .= ' target="' . esc_attr($item->target) . '"';

         !empty($item->xfn)
            and $attributes .= ' rel="'    . esc_attr($item->xfn) . '"';

         !empty($item->url)
            and $attributes .= ' href="'   . esc_attr($item->url) . '"';


         if (!empty($sub_title)) {

            $sub_title = '<sub>' . $sub_title . '</sub>';

            $item_output = $args->before
               . "<a $attributes>"
               . $args->link_before
               . $title
               . $sub_title
               . '</a> '
               . $args->link_after
               . $args->after;
         } else {
            $item_output = $args->before
               . "<a $attributes>"
               . $args->link_before
               . $title
               . '</a> '
               . $args->link_after
               . $args->after;
         }


         // Since $output is called by reference we don't need to return anything.
         $output .= apply_filters(
            'walker_nav_menu_start_el',
            $item_output,
            $item,
            $depth,
            $args
         );
      }
   }
}
