<?php
/**
 * Plugin Name: Xrispi On-Site
 * Plugin URI: https://xrispi.com/
 * Description: Installs xrispi on-site in your word press
 * Version: 1.2
 * Author: Xrispi Labs LTD.
 * Author URI: https://xrispi.com
 * License: GPL2
 */

function xrispi_onsite_wp_head_action() {
	$output = '<script src="//s.xrispi.com/static/xriscript/xriscript.nocache.js" data-xrispi="{&quot;platform&quot;:&quot;wp&quot;,&quot;v&quot;:&quot;1.1&quot;}"></script>';
	echo $output;
}

add_action( 'wp_head', 'xrispi_onsite_wp_head_action');