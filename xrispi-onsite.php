<?php
/**
 * Plugin Name: Xrispi On-Site
 * Plugin URI: https://xrispi.com/
 * Description: Installs xrispi on-site in your word press
 * Version: 1.1
 * Author: Xrispi Labs LTD.
 * Author URI: https://xrispi.com
 * License: GPL2
 */

function xrispi_onsite_wp_head_action() {
	$output = '<script src="//s.xrispi.com/static/xriscript/xriscript.nocache.js" data-xrispi="{platform:\'wp\', v:\'1.1\'}"></script>';
	echo $output;
}

add_action( 'wp_head', 'xrispi_onsite_wp_head_action');