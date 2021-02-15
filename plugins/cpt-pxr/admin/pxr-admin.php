<?php
/**
 * Add admin scripts and styles
 */
if ( !function_exists( 'pxr_add_scripts' ) ) {
	function pxr_add_scripts($hook) {
		
		// Add general styles
		wp_enqueue_style('pxr-admin-css', PXR_CORE_PLUGIN_URL . '/assets/css/admin.css', array(), PXR_CORE_VERSION);
		wp_enqueue_style( 'pxr-fontawesome', PXR_CORE_PLUGIN_URL . '/assets/css/font-awesome.min.css', array(), PXR_CORE_VERSION);
		wp_enqueue_style( 'pxrfont-icon', PXR_CORE_PLUGIN_URL . '/assets/css/pxr-icon-font.css', array(), PXR_CORE_VERSION);

		wp_enqueue_script( 'pxradmin-js', PXR_CORE_PLUGIN_URL . '/assets/js/admin.js', array( 'jquery'), PXR_CORE_VERSION);

	}
}

add_action( 'admin_enqueue_scripts', 'pxr_add_scripts', 10 );


