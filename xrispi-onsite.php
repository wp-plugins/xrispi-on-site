<?php
/**
 * Plugin Name: Xrispi On-Site
 * Plugin URI: https://xrispi.com/
 * Description: Installs xrispi on-site in your word press
 * Version: 1.0
 * Author: Xrispi Labs LTD.
 * Author URI: https://xrispi.com
 * License: GPL2
 */

function xrispi_onsite_wp_head_action() {
	$output = '<script src="//s.xrispi.com/static/xriscript/xriscript.nocache.js"></script>';
	echo $output;
}

add_action( 'wp_head', 'xrispi_onsite_wp_head_action');