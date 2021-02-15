<?php
/*
* 
* Google Map Shortcodes
* 	
*/

if (!function_exists("pxr_google_map_scripts")) {
   function pxr_google_map_scripts()
   {

      wp_enqueue_script('pxr-googlmaps', PXR_CORE_PLUGIN_URL . 'assets/js/googlemaps.js', array('jquery'), PXR_CORE_VERSION, false);
   }
   add_action('pxr_google_map_display', 'pxr_google_map_scripts');
}



if (!function_exists("pxr_google_map")) {
   /**
    * Google Map Holder Shortcode 
    * 
    * @param array $atts  
    * @param string $content  
    * @return html $google_map
    */
   function pxr_google_map($atts, $content = null)
   {

      global $pxr_map_id, $pxr_total_location, $pxr_location_count, $pxr_locations_output, $pxr_zoom;

      extract(shortcode_atts(array(
         "map_id" => "map-" . rand(100000, 1000000),
         "height" => 300,
         "zoom" => 3,
         "class" => "",
      ), $atts));

      //fix map id if empty
      $map_id =  empty($map_id) ? 'map-' . rand(100000, 1000000) : $map_id;

      //class
      $class = !empty($class) ? ' ' . $class : "";

      //load google api
      if (!empty(pxr_get_option('googlemaps_options', 'googlemap_api'))) :
         $api_key = pxr_get_option('googlemaps_options', 'googlemap_api');
      endif;

      if (!empty($api_key)) {
         $googlemaps_url = add_query_arg('key', urlencode($api_key), "//maps.googleapis.com/maps/api/js");
         wp_enqueue_script('googlemaps', $googlemaps_url, array(), '1.0.0');
      } else {
         wp_enqueue_script('googlemaps', '//maps.googleapis.com/maps/api/js');
      }

      //find total location number
      $total_location = substr_count($content, '[location');

      //global values
      $pxr_map_id = $map_id;
      $pxr_total_location = $total_location;
      $pxr_location_count = 0;
      $pxr_locations_output = "";
      $pxr_zoom = $zoom;

      //content
      $content = do_shortcode($content);
      if (!empty(pxr_get_option('googlemaps_options', 'google_mark'))) {
         $markerclr = pxr_get_option('googlemaps_options', 'google_mark');
      } else {
         $markerclr = 'red';
      }

      if (!empty(pxr_get_option('googlemaps_options', 'google_mark_stroke'))) {
         $markerstr = pxr_get_option('googlemaps_options', 'google_mark_stroke');
      } else {
         $markerstr = 'black';
      }

      //output
      $google_map = sprintf('<div class="google_map_holder%s" data-height="%s" data-scope="#%s" data-marker="%s" data-markerstr="%s">%s</div>', $class, $height, $map_id, $markerclr, $markerstr, $content);

      return $google_map;
   }
}



if (!function_exists("pxr_map_location")) {
   /**
    * Google Map Single Location
    * 
    * @param  array $atts  
    * @param  string $content  
    * @return html $js_output
    */
   function pxr_map_location($atts, $content = null)
   {
      global $pxr_map_id, $pxr_total_location, $pxr_location_count, $pxr_locations_output, $pxr_zoom;

      extract(shortcode_atts(array(
         "title" => "",
         "lat" => 0,
         "lon" => 0,
      ), $atts));

      $pxr_location_count++;


      //locations_output
      $new_pxr_location = !empty($lat) && !empty($lon) ?  sprintf('["%s", %s, %s, 4,"%s"],', addslashes($title), $lat, $lon, addslashes($content)) : "";

      $pxr_locations_output .= preg_replace('~[\r\n\t]+~', '', $new_pxr_location);


      if ($pxr_total_location == $pxr_location_count) {

         //js script to run
         $js_output = sprintf('

			<div id="%s" class="google_map"></div>
			<script type="text/javascript">
			 /* <![CDATA[ */ 
				// Runs google maps	
					jQuery(function() {
						jQuery("#%s").pxr_maps([%s],%s); 
					});
			/* ]]> */	
			</script>

		', $pxr_map_id, $pxr_map_id, $pxr_locations_output, $pxr_zoom);

         return $js_output;
      }
   }
}

add_shortcode('google_maps', 'pxr_google_map');
add_shortcode('location', 'pxr_map_location');



if (!function_exists("pxr_map_display")) {
   function pxr_map_display($lat, $lon)
   {

      do_action('pxr_google_map_display');

      $locations = sprintf('[location lat="%s" lon="%s"][/location]', $lat, $lon);

      $map = sprintf('[google_maps zoom="%s"]%s[/google_maps]', '17', $locations);

      echo do_shortcode($map, false);
   }
   add_action('pxr_map_display_action', 'pxr_map_display', 10, 2);
}
