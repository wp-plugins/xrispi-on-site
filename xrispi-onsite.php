<?php
/**
 * Plugin Name: Xrispi On-Site
 * Plugin URI: https://xrispi.com/
 * Description: Installs xrispi on-site in your word press
 * Version: 1.3
 * Author: Xrispi Labs LTD.
 * Author URI: https://xrispi.com
 * License: GPL2
 */

function xrispi_onsite_wp_head_action() {
	$guid = get_option( 'xrispi_onsite_publisher_guid', false );
	$output = "<script>\n";
	if($guid) {
		$output .= "var XrispiOptions = {publisher:'".$guid."'};\n";
	}
	$output .= "(function(w,d,t,s){var a=d.createElement(t),m=d.getElementsByTagName(t)[0]; a.async=1; a.src=s;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//s.xrispi.com/static/xriscript/xriscript.nocache.js');\n</script>\n";
	echo $output;
}

function xrispi_onsite_api_init() {
	add_settings_section(
		'xrispi_onsite_setting_section',
		'Xrispi Publishing',
		'xrispi_onsite_setting_section_callback_function',
		'reading'
	);
	
	
	// Add the field with the names and function to use for our new settings, put it in our new section
	add_settings_field(
		'xrispi_onsite_publisher_guid',
		'Publishing folder',
		'xrispi_onsite_setting_callback_function',
		'reading',
		'xrispi_onsite_setting_section'
	);
	
	register_setting( 'reading', 'xrispi_onsite_publisher_guid' );
	
}

function xrispi_onsite_setting_section_callback_function() {
?>
<p>
In this section, you are able to link your Xrispi account directly to your website, allowing all website visitors to see and engage with each xrisp you publish.<br />
<a href="https://xrispi.com/publisher/" target="_blank">Read More</a>
</p>
<?php
}

function xrispi_onsite_setting_callback_function() {
	$setting = esc_attr( get_option( 'xrispi_onsite_publisher_guid' ) );
	echo "<input type='text' name='xrispi_onsite_publisher_guid' value='$setting' />";
}

add_action( 'wp_head', 'xrispi_onsite_wp_head_action');
add_action( 'admin_init', 'xrispi_onsite_api_init' );